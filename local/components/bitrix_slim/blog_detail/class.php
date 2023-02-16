<?php

use App\Repositories\CatalogRepository;
use App\Repositories\SectionRepository;
use \Bitrix\Main\Loader;
use \Bitrix\Main\Application;

CBitrixComponent::includeComponentClass("bitrix_slim:blog_parent");

/**
 *
 * @params Bitrix\Main\HttpRequest $serverRequest - объект HttpRequest
 */
class BlogDetail extends BlogParent {


    /**
     * Подготовка параметров компонента
     * @param array $arParams - массив параметров для компонента
     * @return array
     */
    public function onPrepareComponentParams($arParams): array
    {
        return parent::onPrepareComponentParams($arParams);
    }
    /**
     * Точка входа в компонент
     * Должна содержать только последовательность вызовов вспомогательых ф-ий и минимум логики
     * всю логику стараемся разносить по классам и методам
     */
    public function executeComponent() {

        //в try catch обернем при вызове компонента
        $this->init();
        $detailId = $this->getDetailId();
        $this->detail($detailId);
        $this->includeComponentTemplate();
    }


}