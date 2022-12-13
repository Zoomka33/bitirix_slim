<?php

namespace App\Middlewares;

use App\Tables\IBlockTable;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Middleware для объявления констант инфоблоков
 *
 * Для выборки используется Bitrix ORM
 * Кэширование 36000 сек
 */
class CIBlockConstsMiddleware
{
    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $iblockAr = IBlockTable::GetList([
            'select' => ['*'],
            'filter' => [
                'ACTIVE' => 'Y',
                'LID' => SITE_ID,
            ],
            'cache' => ['ttl' => 3600],
        ]);

        while ($iblockRes = $iblockAr->fetch()) {
            if ($iblockRes['CODE'] != '') {
                define($iblockRes['CODE'], $iblockRes['ID']);
            }
        }

        return $handler->handle($request);
    }
}