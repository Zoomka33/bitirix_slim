<?php
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
