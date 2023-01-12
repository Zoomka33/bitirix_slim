<?php
// Роуты
// Миддлворы в /http/middleware.php

use App\Controller\AboutController;
use App\Controller\MainController;
use App\Controller\NewsController;
use App\Controller\CatalogController;
use App\Modules\Page404;

$app->get('/', MainController::class . ':index')->setName('home');
$app->get('/aa/', MainController::class . ':index');
$app->get('/about/', AboutController::class . ':index')->setName('about');

$app->get('/catalog/', CatalogController::class . ':index')->setName('catalog.list');
$app->get('/catalog/{sectionCode}/', CatalogController::class . ':bySection')->setName('catalog.section');

$app->get('/news/', NewsController::class . ':index')->setName('news');
$app->get('/news/{id}/', NewsController::class . ':detail')->setName('news.detail');

$app->get('/{slug}/', Page404::class)->setName('page404');