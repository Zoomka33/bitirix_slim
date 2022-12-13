<?php

namespace App\Tables;

use \Bitrix\Main\Entity;
use \Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Fields\BooleanField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\File\File;

class PropertyElementTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'b_iblock_element_property';
    }

    public static function getMap()
    {
        return [
            new IntegerField('ID', [
                'primary' => true,
                'autocomplete' => true,
            ]),
            new StringField('IBLOCK_PROPERTY_ID'),
            new IntegerField('IBLOCK_ELEMENT_ID'),
            new StringField('VALUE'),

        ];
    }
}