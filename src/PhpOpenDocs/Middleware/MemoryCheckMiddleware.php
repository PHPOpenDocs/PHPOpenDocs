<?php

declare(strict_types = 1);

namespace PhpOpenDocs\Middleware;

use Psr\Http\Message\ResponseInterface;
use PhpOpenDocs\Service\MemoryWarningCheck\MemoryWarningCheck;
use Psr\Http\Message\ServerRequestInterface as Request;

// Check to make sure that not too much memory is being used.
// in dev, just return an error.
// in production, log it.

class MemoryCheckMiddleware
{
    /** @var \PhpOpenDocs\Service\MemoryWarningCheck\MemoryWarningCheck */
    private $memoryWarningCheck;

    /**
     *
     * @param MemoryWarningCheck $memoryWarningCheck
     */
    public function __construct(MemoryWarningCheck $memoryWarningCheck)
    {
        $this->memoryWarningCheck = $memoryWarningCheck;
    }

    public function __invoke(Request $request, ResponseInterface $response, $next)
    {
        /** @var ResponseInterface $response */
        $response = $next($request, $response);
        $percentMemoryUsed = $this->memoryWarningCheck->checkMemoryUsage($request);

        $response = $response->withAddedHeader('X-Debug-Memory', $percentMemoryUsed . '%');

        return $response;
    }
}
