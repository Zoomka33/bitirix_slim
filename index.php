<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
\Bitrix\Main\Loader::includeModule('iblock');
\Bitrix\Main\Loader::includeModule("catalog");
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
try {

    $app = AppFactory::create();

    require __DIR__ . '/http/middleware.php';
    require __DIR__ . '/http/routes.php';
//    dump($app->getRouteCollector()->getRoutes());

    $app->run();
} catch (App\Exceptions\NotFoundException $ex) {
    $ex->view();
} catch (\Exception $ex) {
    die();
}
