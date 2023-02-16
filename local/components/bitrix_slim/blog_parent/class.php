<?php

use App\Repositories\CatalogRepository;
use App\Repositories\FileRepository;
use App\Repositories\SectionRepository;
use App\Repositories\UserRepository;
use \Bitrix\Main\Loader;
use \Bitrix\Main\Application;
use Jenssegers\Blade\Blade;
use \Bitrix\Iblock\Elements\ElementBlogsTable;
use Bitrix\Iblock\Elements\EO_ElementBlogs;

/**
 *
 * @params Bitrix\Main\HttpRequest $serverRequest - объект HttpRequest
 */
class BlogParent extends CBitrixComponent {

    protected static $tableClass = ElementBlogsTable::class;

    protected \Bitrix\Main\HttpRequest $serverRequest;

    const MODULES_EXCEPTION = 'Не загружены модули необходимые для работы модуля';

    /**
     * Метод инициализации параметров и выполнения необходимых проверок
     *
     * @return void
     * @throws Exception
     */
    protected function init(): void
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
    protected function getApp(): CMain
    {
        global $APPLICATION;
        return $APPLICATION;
    }

    /**
     * Обертка над глобальной переменной
     *
     * @return CUser
     */
    protected function getUser(): CUser
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

        if (!$arParams['IBLOCK_ID']) {
            /** @var const blogs - 6 (см. init.php) */
            $arParams['IBLOCK_ID'] = blogs;
        }
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
        $page = $this->serverRequest->get('page');
        $list = $this->list($page, 10);
//        $blade = new Blade($_SERVER['DOCUMENT_ROOT'] .'/resources/views/', $_SERVER['DOCUMENT_ROOT'].'/cache');
//
//        echo $blade->render('test.test', ['name' => 'John Doe']);

        $this->arResult['items'] = $list;
        $this->arResult['pagination'] = (int)$page ?? 1;
        $this->includeComponentTemplate();
    }

    public function list(?int $pageNumber = 0, int $countElements = 10)
    {
        $result = [];

        $pagination = $this->getPaginationByPageNumber($pageNumber, $countElements);
        $res = self::$tableClass::getList([
            'order' => [
                'SHOW_COUNTER' => 'DESC',
            ],
            'filter' => [
                'IBLOCK_ID' => $this->arParams['IBLOCK_ID'],
            ],
            'select' => [
                'ID',
                'NAME',
                'PREVIEW_TEXT',
                'PREVIEW_PICTURE',
                'SECTION_ID' => 'SECTIONS.ID',
                'SECTION_NAME' => 'SECTIONS.NAME',
                'TIMESTAMP_X',
                'CREATED_BY',
                'SHOW_COUNTER',
//                'TIME_TO_READ_' => 'TIME_TO_READ',
                'USER.NAME',
//                'RECOMMEND_PRODUCT.ELEMENT',
            ],
            'runtime'=>[
                new \Bitrix\Main\Entity\ReferenceField(
                    'USER',
                    \Bitrix\Main\UserTable::class,
                    ['this.CREATED_BY'=>'ref.ID'],
                    ['join_type'=>'inner'],
                ),
            ],
            'offset' => $pagination['offset'],
            'limit' => $pagination['limit'],
            'cache' => ['ttl' => 3600],
        ])->fetchCollection();
        foreach ($res as $ar) {
            $result[] = $this->formatter($ar);
        }

        $this->arResult['items'] = $result;
        $this->arResult['page'] = $pageNumber;
    }

    public function detail(int $id)
    {
        $res = self::$tableClass::getByPrimary($id,
            [
                'select' => [
                    'ID',
                    'NAME',
                    'DETAIL_TEXT',
                    'DETAIL_PICTURE',
                    'ACTIVE_FROM',
                    'CREATED_BY',
                    'SHOW_COUNTER',
                    'SECTION_ID' => 'SECTIONS.ID',
                    'SECTION_NAME' => 'SECTIONS.NAME',
                    'TIMESTAMP_X',
                    'SHOW_COUNTER',
                    'TIME_TO_READ_' => 'TIME_TO_READ',
                    'USER.NAME',
                    'RECOMMEND_PRODUCT.ELEMENT',
                ],
                'runtime'=>[
                    new \Bitrix\Main\Entity\ReferenceField(
                        'USER',
                        \Bitrix\Main\UserTable::class,
                        ['this.CREATED_BY'=>'ref.ID'],
                        ['join_type'=>'inner'],
                    ),
                ],
                'cache' => ['ttl' => 3600],
            ]
        )->fetchObject();
        if (!$res) {
            //или выбросить исключение
            $this->arResult['DATA'] = [];
        } else {
            $this->arResult['DATA'] = $this->formatter($res);
        }
    }

    private function formatter(EO_ElementBlogs $ar): array
    {
        $section = $ar->getSections()->getAll()[0];
        $product = [];
        if ($ar->getRecommendProduct()) {
            $product = [
                'id' => $ar->getRecommendProduct()->getId(),
                'name' => $ar->getRecommendProduct()->getElement()->getName()
            ];
        }
        $timeToRead = '';
        if ($ar->getTimeToRead()) {
            $timeToRead = (int)$ar->getTimeToRead()->getValue();
        }
        return [
            'id' => $ar->getId(),
            'timeToRead' => $timeToRead,
            'recommendProduct' => $product,
            'title' => $ar->getName(),
            'text' => $ar->getPreviewText(),
            'author' => $ar->get('USER')->getName(),
            'sectionName' => $section->getName(),
            'sectionCode' => $section->getCode(),
            'date' => $ar->getTimestampX()->format('d F Y'),
            'show' => $ar->getShowCounter(),
            'picture' => FileRepository::getById($ar->getPreviewPicture()),
        ];
    }

    /**
     * Пагинация для lazyload, где страница начинается с 0
     *
     * @param int|null $page
     * @param int $limit
     * @return array
     */
    protected function getPaginationByPageNumber(?int $page = 0, int $limit = 10): array
    {
        if ($page == 0) {
            $page = 1;
        }
        //пагинация начинается с 0
        $offset = ($page - 1) * $limit;
        return [
            'offset' => $offset,
            'limit' => $offset + $limit
        ];
    }

    public function getDetailId(): ?int
    {
        return (int)explode('/', $this->serverRequest->getRequestedPageDirectory())[1];
    }

    public function getPage(): int
    {
        return $this->serverRequest->get('page') ?? 0;
    }

}