<?php

namespace App\Repositories;

class AbstractRepository
{
    public static array $filter = [];

    public static function getPagination(int $pageNumber, int $countElements = 10): array
    {
        $filter = array_merge(
            self::$filter,
            [
                'IBLOCK_ID' => furniture_products_s1,
            ]
        );
        $cnt = static::$tableClass::getList([
            'filter' => $filter,
            'select' => [
                'ID',
                'SECTION_ID' => 'SECTIONS.ID',
                'SECTION_NAME' => 'SECTIONS.NAME',
                'SECTION_CODE' => 'SECTIONS.CODE',
                'CNT' => 'CNT'
            ],
            'runtime' => [
                new \Bitrix\Main\Entity\ExpressionField(
                'CNT',
                'COUNT(%s)',
                    ['ID']
                ),
            ],
            'count_total' => true,
        ])->getCount();


        $paginationCount = (int)ceil($cnt / $countElements);

        if ($pageNumber == 0) {
            $pageNumber = 1;
        }

        // если номер выбрано страницы больше чем кол-во страниц, получаем последнюю страницу
        if ($pageNumber > $paginationCount) {
            $pageNumber = $paginationCount;
        }

        return [
            'pageSize' => $countElements, // кол-во элементов на странице
            'totalSize' => $paginationCount, // кол-во страниц
            'pageNumber' => $pageNumber, // номер текущей страницы
            'offset' => ($pageNumber - 1) * $countElements, // -1 потому что паганация начинается с 0, 1, 2 ...,
                                                            // а вывод пагинации с 1, 2, 3...
            'limit' => $countElements, // ограничение по выборке
        ];
    }

    public static function setFilter(array $filter): void
    {
        self::$filter = $filter;
    }
}