<?php

namespace App\Repositories;

use \Bitrix\Iblock\SectionTable;

/**
 * https://dev.1c-bitrix.ru/community/webdev/user/1248769/blog/36218/
 */
class SectionRepository extends AbstractRepository
{
    public static $tableClass = SectionTable::class;


    public static function getAllByIblock(int $iblockId): array
    {
        $result = [];

        $res = self::$tableClass::getList([
            'filter' => [
                'IBLOCK_ID' => $iblockId
            ],
            'select' => [
                'ID',
                'NAME',
                'CODE',
            ],
        ])->fetchCollection();

        foreach ($res as $ar) {
            $result[] = [
                'id' => $ar->getId(),
                'code' => $ar->getCode(),
                'title' => $ar->getName(),
            ];
        }

        return $result;
    }
}