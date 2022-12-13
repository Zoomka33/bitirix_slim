<?php

namespace App\Modules;

use App\View\View;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Page404
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $page = View::renderHtml('service.404');
        $response->withStatus(StatusCodeInterface::STATUS_NOT_FOUND);
        $response->getBody()->write($page);
        return $response;
    }
}