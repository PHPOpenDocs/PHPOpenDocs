<?php

declare(strict_types = 1);

namespace PHPOpenDocs\ApiController;

//use SlimAuryn\Routes;
use SlimAuryn\Response\JsonResponse;

class Index
{
    public function getRouteList(/*Routes $routes */): JsonResponse
    {

        $routes = require __DIR__ . "/../../../routes/api_routes.php";

        return new JsonResponse($routes);
    }
}
