<?php

use App\Repositories\CatalogRepository;
use App\Repositories\SectionRepository;
use \Bitrix\Main\Loader;
use \Bitrix\Main\Application;

// Данная конструкция не требуется, так как подключение компонента происходит внутри slim
// (nginx все запросы на /index.php ведет)
// if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * Компонент получился "божественным", мы в нем получаем все данные необходимые для отрисовки страницы
 * Можно разнести логику по разным компонентам
 * Вместо использования репозиториев/сервисов можно писать логику внутри компонента
 *
 * @params Bitrix\Main\HttpRequest $serverRequest - объект HttpRequest
 */
class ProductsList extends CBitrixComponent {

    private \Bitrix\Main\HttpRequest $serverRequest;

    const MODULES_EXCEPTION = 'Не загружены модули необходимые для работы модуля';

    /**
     * Метод инициализации параметров и выполнения необходимых проверок
     *
     * @return void
     * @throws Exception
     */
    private function init(): void
    {
        if (!Loader::includeModule('iblock') || !Loader::includeModule('sale'))
        {
            throw new \Exception(self::MODULES_EXCEPTION, 500);
        }
        //оставлю здесь, но можно перенести в миддлевэре
        $this->serverRequest = Application::getInstance()->getContext()->getRequest();

        return;
    }

    /**
     * Обертка над глобальной переменной
     *
     * @return CMain
     */
    private function getApp(): CMain
    {
        global $APPLICATION;
        return $APPLICATION;
    }

    /**
     * Обертка над глобальной переменной
     *
     * @return CUser
     */
    private function getUser(): CUser
    {
        global $USER;
        return $USER;
    }

    /**
     * Подготовка параметров компонента
     * @param array $arParams - массив параметров для компонента
     * @return array
     */
    public function onPrepareComponentParams($arParams): array
    {
        // обработка $arParams
        return $arParams;
    }

    /**
     * Точка входа в компонент
     * Должна содержать только последовательность вызовов вспомогательых ф-ий и минимум логики
     * всю логику стараемся разносить по классам и методам
     */
    public function executeComponent() {

        //в try catch обернем при вызове компонента
        $this->init();
        $page = $this->serverRequest->get('page') ?? 1;
        $iblockId = $this->arParams['IBLOCK_ID'];

        /**
         * Кэширование можно организовать по-разному, например внутри сервисов/репозиториев через редис (или любой другой сервис)
         * или на уровне orm битрикса (как в текущем примере)
         * или "компонентным" способом типо
         * if($this->startResultCache()) { логика }
         */
        $this->arResult['SEO'] = $this->getSeo();

        //логику из репозитория можно вынести внутрь компонента
        $this->arResult['PRODUCTS'] = CatalogRepository::list((int)$page);
        $this->arResult['PAGINATION'] = CatalogRepository::getPagination((int)$page);
        $this->arResult['SECTIONS'] = SectionRepository::getAllByIblock((int)$iblockId);

        $this->setSeo();

        // либо includeComponentTemplate - для подключения шаблона
        // либо return $this->arResult - для возвращения результата работы компонента
        $this->includeComponentTemplate();
    }

    /**
     * Метод возвращает хлебные крошки
     *
     * @deprecated - лучше вынести в отдельный компонент либо использовать стандартный
     * @return array
     */
    private function getBreadcrumbs(): array
    {
        return [
            'Главная' => '/',
            'Каталог' => '',
        ];
    }

    /**
     * Метод возвращает сео
     *
     * @return array
     */
    private function getSeo(): array
    {
        return [
            'title' => 'Каталог',
            'description' => 'Страница Каталог интернет магазина',
            'keywords' => ''
        ];
    }

    /**
     * Метод назначает сео для отложенных функций
     *
     * @return void
     */
    private function setSeo(): void
    {
        $this->getApp()->setPageProperty('title', 'Каталог');
        $this->getApp()->setPageProperty('description', 'Страница Каталог интернет магазина');
        $this->getApp()->setPageProperty('keywords', '');
    }
}