<?php

namespace App\Repositories;

use \Bitrix\Main\UserTable;

class UserRepository
{
    public static $tableClass = UserTable::class;

    public static function getById(?int $id): array
    {
        if ($id) {
            $res = self::$tableClass::getByPrimary($id, [
                'select' => ['*'],
                'cache' => [
                    'ttl' => 60
                ],

            ])->fetchObject();
            $result = [
                'id' => $res->getId(),
                'name' => $res->getName(),
            ];
        }
        return $result ?? [];
    }

    public static function getByIds(?array $ids): array
    {
        if (!empty($ids)) {
            $usersRes = self::$tableClass::getList([
                'filter' => ['ID' => $ids],
                'select' => ['ID', 'NAME']
            ])->fetchCollection();

            foreach ($usersRes as $user) {
                $result[$user->getId()] = [
                    'id' => $user->getId(),
                    'name' => $user->getName(),
                ];
            }
        }

        return $result ?? [];
    }
}