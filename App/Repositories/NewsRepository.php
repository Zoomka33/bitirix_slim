<?php

namespace App\Repositories;

use \Bitrix\Iblock\Elements\ElementNewsTable;

class NewsRepository
{
    public static $tableClass = ElementNewsTable::class;


    public static function list(): array
    {
        $result = [];
        $res = self::$tableClass::getList([
            'filter' => [
                'IBLOCK_ID' => furniture_news_s1,
            ],
            'select' => [
                'ID',
                'NAME',
                'PREVIEW_TEXT',
                'PREVIEW_PICTURE',
                'ACTIVE_FROM',
                'CREATED_BY',
                'SHOW_COUNTER',
                'TITLE',
                'CATEGORY.ITEM',
                'IBLOCK_SECTION_ID',
                'USER.NAME'
            ],
            'runtime'=>[
                new \Bitrix\Main\Entity\ReferenceField(
                    'USER',
                    \Bitrix\Main\UserTable::class,
                    ['this.CREATED_BY'=>'ref.ID'],
                    ['join_type'=>'inner'],
                ),
            ]
        ])->fetchCollection();
        foreach ($res as $ar) {
            if ($ar->getCategory()) {
                $category = $ar->getCategory()->getItem()->getValue();
            }
            $result[] = [
                'id' => $ar->getId(),
                'title' => $ar->getName(),
                'text' => $ar->getPreviewText(),
                'author' => $ar->get('USER')->getName(),
                'category' => $category ?? '',
                'date' => $ar->getActiveFrom()->format('d F Y'),
                'show' => $ar->getShowCounter(),
                'picture' => FileRepository::getById($ar->getPreviewPicture()),
            ];
        }

        return $result;
    }

    public static function detail(int $id): array
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
                'TITLE',
                'CATEGORY.ITEM',
            ]
        ])->fetchObject();

        if ($res->getCategory()) {
            $category = $res->getCategory()->getItem()->getValue();
        }

        if ($res->getTitle()) {
            $title = $res->getTitle()->getValue();
        }

        return [
            'id' => $res->getId(),
            'title' => $res->getName(),
            'text' => $res->getDetailText(),
            'author' => UserRepository::getById($res->getCreatedBy())['name'],
            'category' => $category ?? '',
            'date' => $res->getActiveFrom()->format('d F Y'),
            'show' => $res->getShowCounter(),
            'picture' => FileRepository::getById($res->getDetailPicture()),
            'pageTitle' => $title ?? '',
        ];
    }
}