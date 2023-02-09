<?php

declare(strict_types = 1);

namespace PHPOpenDocs\Middleware;

use Psr\Http\Message\ResponseInterface;
use PHPOpenDocs\MemoryWarningCheck\MemoryWarningCheck;
use Psr\Http\Message\ServerRequestInterface as Request;
use CIDRmatch\CIDRmatch;

class AllowedAccessMiddleware
{
    /** @var string[] */
    private $allowedCidrs;

    /**
     * A list of paths that are always allowed, regardless
     * of whether the IP address matches a known CIDR
     * @var string[]
     */
    private $allowedPaths;

    /** @var string */
    private $notAllowedPath;


    /**
     *
     * @param array $allowedCidrs The IP addresses to allow.
     * @param array $allowedPaths Paths to always allow and do not redirect
     * @param string $notAllowedPath The path to redirect people to
     */
    public function __construct(
        array $allowedCidrs,
        array $allowedPaths,
        string $notAllowedPath
    ) {
        $this->allowedCidrs = $allowedCidrs;
        $this->allowedPaths = $allowedPaths;
        $this->notAllowedPath = $notAllowedPath;
    }

    private function isAllowedAccess(Request $request): bool
    {
        $path = $request->getUri()->getPath();

        if (array_contains($path, $this->allowedPaths) === true) {
            return true;
        }


        $ipAddress = getClientIpAddress();

        $cidrMatch = new CIDRmatch();

        foreach ($this->allowedCidrs as $allowedCidr) {
            if ($cidrMatch->match($ipAddress, $allowedCidr) === true) {
                return true;
            }
        }

        return false;
    }

    public function __invoke(
        Request $request,
        ResponseInterface $response,
        callable $next
    ): ResponseInterface {
        if ($this->isAllowedAccess($request) !== true) {
            $response = $response->withStatus(303)
                ->withHeader('Location', $this->notAllowedPath);
            return $response;
        }

        /** @var ResponseInterface $response */
        $response = $next($request, $response);

        return $response;
    }
}
