<?php

namespace App\Repositories;

use \Bitrix\Main\FileTable;

class FileRepository
{
    public static $tableClass = FileTable::class;

    public static function getById(?int $id): string
    {
        if ($id) {
            $res = self::$tableClass::getByPrimary($id, [
                'select' => ['*'],
                'cache' => [
                    'ttl' => 60
                ],

            ])->fetchObject();
            $url = '/upload/' . $res->getSubdir() . '/' . $res->getFileName();
        }
        return $url ?? '';
    }
}