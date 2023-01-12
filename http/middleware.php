<?php
// Подключаем миддлворы
// Миддлворы лежат в /App/Middleware/

use App\Middlewares\CIBlockConstsMiddleware;
use App\Middlewares\GlobalRequestMiddleware;

//$notFoundMiddleware = NotFoundMiddleware::class;
//$app->addErrorMiddleware(true, true, true);
$app->add(new CIBlockConstsMiddleware());
$app->add(new GlobalRequestMiddleware());