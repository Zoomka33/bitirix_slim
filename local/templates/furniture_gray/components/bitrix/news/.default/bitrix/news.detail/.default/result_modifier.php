<?php
if (!empty($arParams['CANONICAL'])) {
    $arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM");
    $arFilter = Array("IBLOCK_ID"=>$arParams['CANONICAL'], 'PROPERTY_NEW' => $arResult['ID'], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    if($ob = $res->GetNextElement())
    {
        $arFields = $ob->GetFields();
        $arResult['CANONICAL_LINK'] = $arFields['NAME'];
        $this->__component->SetresultCacheKeys(['CANONICAL_LINK']);
    }
}
