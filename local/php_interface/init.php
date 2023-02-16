<?php

use App\Tables\IBlockTable;

require_once '/var/www/bitrix/html/vendor/autoload.php';

$iblockAr = IBlockTable::GetList([
    'select' => ['*'],
    'filter' => [
        'ACTIVE' => 'Y',
        'LID' => SITE_ID,
    ],
    'cache' => ['ttl' => 3600],
]);

while ($iblockRes = $iblockAr->fetch()) {
    if ($iblockRes['CODE'] != '') {
        define($iblockRes['CODE'], $iblockRes['ID']);
    }
}

IncludeModuleLangFile(__FILE__);
AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", "OnBeforeIBlockElementUpdateHandler");

function OnBeforeIBlockElementUpdateHandler(&$arFields)
{
    if($arFields["IBLOCK_ID"] == 2)
    {
        if ($arFields["ACTIVE"] == 'N') {
            $arSelect = Array("ID", "SHOW_COUNTER");
            $arFilter = Array("IBLOCK_ID"=>2, 'ID' => $arFields['ID']);
            $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect)->fetch();
            if ($res['SHOW_COUNTER'] > 2) {
                global $APPLICATION;
                $APPLICATION->throwException(GetMessage('COUNTER', ['#COUNT#' => $res['SHOW_COUNTER']]));
                return false;
            }
        }
    }
}
