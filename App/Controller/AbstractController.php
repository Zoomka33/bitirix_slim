<?php

namespace App\Controller;

use App\View\View;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractController
{
    public function view(ResponseInterface $response, string $templateName, array $args = [], ?ServerRequestInterface $request = null): ResponseInterface
    {
        $viewContent = View::renderHtml($templateName, $args, $request);
        $response->getBody()->write($viewContent);
        return $response;
    }

}