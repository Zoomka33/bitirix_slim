<?php

namespace App\Repositories;

use \Bitrix\Iblock\Elements\ElementProductsTable;

/**
 * https://dev.1c-bitrix.ru/community/webdev/user/1248769/blog/36218/
 */
class CatalogRepository extends AbstractRepository
{
    public static $tableClass = ElementProductsTable::class;


    public static function list(?int $pageNumber = 0, int $countElements = 10): array
    {
        $result = [];
        $pagination = self::getPagination($pageNumber, $countElements);

        $filter = array_merge(
            self::$filter,
            [
                'IBLOCK_ID' => furniture_products_s1,
            ]
        );
        $res = self::$tableClass::getList([
            'order' => [
                'BASE' => 'ASC'
            ],
            'filter' => $filter,
            'select' => [
                'ID',
                'NAME',
                'CODE',
                'BASE' => 'PRICETABLE.PRICE',
                'PREVIEW_TEXT',
//                'SEC_ID' => 'SECTION_ID_ELEMENT.IBLOCK_ELEMENT_ID',
//                'SECTION_NAME' => 'SECTION.NAME',
                'SECTION_ID' => 'SECTIONS.ID',
                'SECTION_NAME' => 'SECTIONS.NAME',
                'SECTION_CODE' => 'SECTIONS.CODE',
                'DETAIL_PICTURE',
                'IMG_SRC' => 'IMG.SUBDIR',
                'IMG_FILE_NAME' => 'IMG.FILE_NAME',
            ],
            'runtime'=>[
                new \Bitrix\Main\Entity\ReferenceField(
                    'PRICETABLE',
                    \Bitrix\Catalog\PriceTable::class,
                    ['this.ID'=>'ref.PRODUCT_ID'],
                    ['join_type'=>'left'],
                ),
                new \Bitrix\Main\Entity\ReferenceField(
                    'IMG',
                    \Bitrix\Main\FileTable::class,
                    ['this.DETAIL_PICTURE'=>'ref.ID'],
                    ['join_type'=>'inner'],
                ),
//                new \Bitrix\Main\Entity\ReferenceField(
//                    'SECTION_ID_ELEMENT',
//                    \Bitrix\Iblock\SectionElementTable::class,
//                    ['this.ID'=>'ref.IBLOCK_ELEMENT_ID'],
//                    ['join_type'=>'inner'],
//                ),
//                new \Bitrix\Main\Entity\ReferenceField(
//                    'SECTION',
//                    \Bitrix\Iblock\SectionTable::class,
//                    ['this.SEC_ID'=>'ref.ID'],
//                    ['join_type'=>'inner'],
//                ),
            ],
            'offset' => $pagination['offset'],
            'limit' => $pagination['limit'],
        ])->fetchCollection();

        foreach ($res as $ar) {
            $section = $ar->getSections()->getAll()[0];
            $result[] = [
                'id' => $ar->getId(),
                'code' => $ar->getCode(),
                'title' => $ar->getName(),
                'text' => $ar->getPreviewText(),
                'section' => $section->getName(),
                'price' => $ar->get('PRICETABLE') ? $ar->get('PRICETABLE')->getPrice() : null,
                'discountPrice' => $ar->get('PRICETABLE') ? $ar->get('PRICETABLE')->getPrice() : null, //TODO
                'picture' => '/upload/' . $ar->get('IMG')->getSubdir() . '/' . $ar->get('IMG')->getFileName(),
            ];
        }

        return $result;
    }

    public static function getBySection(string $code, ?int $pageNumber = 0, int $countElements = 10): array
    {
        self::setFilter(['SECTION_CODE' => $code]);
        return self::list($pageNumber, $countElements);
    }
}