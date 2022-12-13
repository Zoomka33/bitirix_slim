<?php

namespace App\Controller;

use App\Exceptions\NotFoundException;
use App\Modules\Cache\RedisCache;
use App\Repositories\CatalogRepository;
use App\Repositories\NewsRepository;
use App\Repositories\SectionRepository;
use App\View\View;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Bitrix\Main\ORM\Fields\ExpressionField;
use Slim\Factory\AppFactory;
use App\Tables\ElementTable;

/**
 * https://it-svalka.ru/blog/bitrix/rabota-s-elementami-infobloka-sredstvami-orm-v-bitriks-d7/
 * https://web-finder.ru/elementy-infobloka-i-ih-svojstva-v-orm-bitriks-yadra-d7
 * https://webteam.by/articles/bitrix/slozhnaya-vyborka-na-orm/
 */
class CatalogController extends AbstractController
{
    public function index(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $query = $request->getQueryParams();
        return $this->view($response, 'catalog.list', [
            'header' => [
                'breadcrumbs' => [
                    'Главная' => '/',
                    'Каталог' => '',
                ],
                'title' => 'Каталог',
            ],
            'products' => CatalogRepository::list((int)$query['p']),
            'pagination' => CatalogRepository::getPagination((int)$query['p']),
            'sections' => SectionRepository::getAllByIblock((int)furniture_products_s1),
            'user' => ['id' => 1, 'name' => 'Alex'],
            'footer' => [

            ]
        ], $request);
    }

    public function bySection(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $query = $request->getQueryParams();
        $products = CatalogRepository::getBySection($args['sectionCode'], (int)$query['p']);
        return $this->view($response, 'catalog.list', [
            'header' => [
                'breadcrumbs' => [
                    'Главная' => '/',
                    'Каталог' => '/catalog/',
                    $products[0]['section'] => ''
                ],
                'title' => $products[0]['section']
            ],
            'products' => $products,
            'pagination' => CatalogRepository::getPagination((int)$query['p']),
            'user' => ['id' => 1, 'name' => 'Alex'],
            'footer' => [

            ]
        ], $request);
    }


    public function detail(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        //TODO
        die();
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