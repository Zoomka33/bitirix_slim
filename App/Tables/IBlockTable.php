<?php

namespace App\Tables;

use \Bitrix\Main\Entity;

class IBlockTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'b_iblock';
    }

    public static function getMap()
    {
        return [
            new Entity\IntegerField('ID', [
                'primary' => true,
                'autocomplete' => true,
            ]),
            new Entity\StringField('IBLOCK_TYPE_ID'),
            new Entity\StringField('LID'),
            new Entity\StringField('CODE'),
            new Entity\StringField('NAME'),
            new Entity\BooleanField('ACTIVE'),
        ];
    }
}