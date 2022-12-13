<?php

namespace App\Controller;

use App\Exceptions\NotFoundException;
use App\Modules\Cache\RedisCache;
use App\Repositories\NewsRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Bitrix\Main\ORM\Fields\ExpressionField;
use Slim\Factory\AppFactory;
use App\Tables\ElementTable;

/**
 * https://it-svalka.ru/blog/bitrix/rabota-s-elementami-infobloka-sredstvami-orm-v-bitriks-d7/
 * https://web-finder.ru/elementy-infobloka-i-ih-svojstva-v-orm-bitriks-yadra-d7
 * https://webteam.by/articles/bitrix/slozhnaya-vyborka-na-orm/
 * https://qna.habr.com/q/685048
 */
class NewsController extends AbstractController
{
    public function index(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return $this->view($response, 'news.list', [
            'header' => [
                'breadcrumbs' => [
                    'Главная',
                    'О компании',
                    'История'
                ],
                'title' => 'Блог',
            ],
            'posts' => NewsRepository::list(),
            'user' => ['id' => 1, 'name' => 'Alex'],
            'footer' => [

            ]
        ], $request);
    }

    public function detail(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $detail = NewsRepository::detail((int)$args['id']);
        return $this->view($response, 'news.detail', [
            'header' => [
                'breadcrumbs' => [
                    'Главная',
                    'О компании',
                    'История'
                ],
                'title' => $detail['pageTitle'],
            ],
            'post' => $detail,
            'user' => ['id' => 1, 'name' => 'Alex'],
            'footer' => [

            ]
        ], $request);
    }
}