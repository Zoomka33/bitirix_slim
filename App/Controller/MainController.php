<?php

namespace App\Controller;

use App\Exceptions\NotFoundException;
use App\Modules\Cache\ObCache;
use App\Modules\Cache\RedisCache;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Factory\AppFactory;

//на текущий момент контроллер для тестов
class MainController extends AbstractController
{
    public function index(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        global $APPLICATION;

        /**
         * @var const furniture_products_s1 - все константы инициализируются в миддлеворе
         * по принципу: код инфоблока = Id инфоблока
         *
         * Так же компонент можно вызвать в любом index.php
         */
        $APPLICATION->IncludeComponent(
            "bitrix_slim:products_list",
            ".default",
            ['IBLOCK_ID' => furniture_products_s1]
        );
        $routeParser = \Slim\Routing\RouteContext::fromRequest($request)->getRouteParser();
        dump($routeParser->urlFor('page404', ['slug' => 'gg'], ['slug' => 'gg']));
//        $redis = (new RedisCache);
        $obCache = (new ObCache);
        $obCache->connection();
        $ff = $obCache->get('key1');
        die();
//        $redis->connection()->set('array', ['key' => 'value', 'kkk' => 'fff']);
        dump($redis->connection()->delete('name', 'alex'));
//        $redis->connection()->get('array', 'alex');
        $user = 1;
        if ($user == null) {
            throw new NotFoundException();
        }
        return $this->view($response, 'main', [
            'header' => [
                'breadcrumbs' => [
                    'Главная',
                    'О компании',
                    'История'
                ],
                'title' => 'История',
            ],
            'user' => ['id' => 1, 'name' => 'Alex'],
            'footer' => [

            ]
        ], $request);
    }
}