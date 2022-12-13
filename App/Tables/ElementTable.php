<?php

namespace App\Tables;

use \Bitrix\Main\Entity;
use \Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Fields\BooleanField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\File\File;

class ElementTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'b_iblock_element';
    }

    public static function getMap()
    {
        return [
            new IntegerField('ID', [
                'primary' => true,
                'autocomplete' => true,
            ]),
            (new Reference(
                'PROPERTY',
                PropertyElementTable::class,
                Join::on('this.ID', 'ref.IBLOCK_ELEMENT_ID')
            ))->configureJoinType('left'),
            (new Reference(
                'PROPERTY_PROP',
                \Bitrix\Iblock\PropertyTable::class,
                Join::on('this.PROPERTY.IBLOCK_PROPERTY_ID', 'ref.ID')
            ))->configureJoinType('left'),
            new StringField('IBLOCK_SECTION_ID'),
            new IntegerField('IBLOCK_ID'),
            (new Reference(
                'IBLOCK',
                \Bitrix\Iblock\IBlockTable::class,
                Join::on('this.IBLOCK_ID', 'ref.ID')
            ))->configureJoinType('inner')->configureTitle('IBLOCK_NAME'),
            new StringField('PREVIEW_TEXT'),
            new IntegerField('PREVIEW_PICTURE'),
            new StringField('DETAIL_TEXT'),
            new StringField('CODE'),
            new StringField('NAME'),
            new StringField('SHOW_COUNTER'),
            new BooleanField('ACTIVE'),
            (new Reference(
                'PREVIEW_PICTURE_SRC',
                \Bitrix\Main\FileTable::class,
                Join::on('this.PREVIEW_PICTURE', 'ref.ID')
            ))->configureJoinType('left')
        ];
//        Join::on('this.ID', 'ref.IBLOCK_ELEMENT_ID')
    }
}