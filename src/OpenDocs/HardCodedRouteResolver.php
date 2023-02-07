<?php

namespace OpenDocs;

use Slim\Interfaces\RouteInterface;
use Slim\Interfaces\RouteResolverInterface;
use Slim\Routing\RoutingResults;

class HardCodedRouteResolver implements RouteResolverInterface
{

    why this so hard?

    /**
     * @param string $uri Should be ServerRequestInterface::getUri()->getPath()
     */
    public function computeRoutingResults(string $uri, string $method): RoutingResults
    {
        \Slim\Routing\RoutingResults::FOUND
    }

    public function resolveRoute(string $identifier): RouteInterface
    {
        throw new \Exception("not implemented");
    }

}