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
class Blog extends BlogParent {


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
//        $detailId = 39;
        if ($detailId) {
            $this->detail((int)$detailId);
            $this->includeComponentTemplate('detail');

        } else {
            $this->list($this->getPage());
            $this->includeComponentTemplate('list');
        }

        //TODO: проблема с кэшем блэйда
//        $blade = new Blade($_SERVER['DOCUMENT_ROOT'] .'/resources/views/', $_SERVER['DOCUMENT_ROOT'].'/cache');
//        echo $blade->render('test.test', ['name' => 'John Doe']);
    }

}