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