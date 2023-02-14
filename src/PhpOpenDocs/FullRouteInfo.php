<?php

declare(strict_types = 1);

namespace PHPOpenDocs;

use Psr\Http\Message\ServerRequestInterface;
use SlimAuryn\RouteParams;

class FullRouteInfo
{
    private ServerRequestInterface $serverRequest;

    private RouteParams $routeParams;

    public function __construct(
        ServerRequestInterface $serverRequest,
        RouteParams $routeParams
    ) {
        $this->routeParams = $routeParams;
        $this->serverRequest = $serverRequest;
    }

    /**
     * @return ServerRequestInterface
     */
    public function getServerRequest(): ServerRequestInterface
    {
        return $this->serverRequest;
    }

    /**
     * @return RouteParams
     */
    public function getRouteParams(): RouteParams
    {
        return $this->routeParams;
    }
}
