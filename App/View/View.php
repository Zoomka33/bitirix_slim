<?php

namespace App\View;

use Psr\Http\Message\ServerRequestInterface;

class View
{
    const TEMPLATE_PATH = '/../../App/Templates/';

    public static function renderHtml(string $templateName, array $args = [], ?ServerRequestInterface $request = null)
    {
        extract($args);

        if ($request) {
            global $routeParser;
            $routeParser = \Slim\Routing\RouteContext::fromRequest($request)->getRouteParser();
        }
        ob_start();
        $path = self::parsePath($templateName);
        require __DIR__ . self::TEMPLATE_PATH . $path;
        $buffer = ob_get_contents();
        ob_end_clean();
        return $buffer;
    }

    private static function parsePath(string $templatePath): string
    {
        $newPath = str_replace('.', '/', $templatePath);
        return $newPath . '.php';
    }

    public static function route(string $name, array $args = [], array $query = []): string
    {
        global $routeParser;
        if ($routeParser) {
            $url = $routeParser->urlFor($name, $args, $query);
        }

        return $url ?? '';
    }


}