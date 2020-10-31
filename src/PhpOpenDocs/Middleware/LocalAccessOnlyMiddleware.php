<?php

declare(strict_types = 1);

namespace PhpOpenDocs\Middleware;

use CIDRmatch\CIDRmatch;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Osf\Service\RequestNonce;
use Osf\Data\ApiDomain;

class LocalAccessOnlyMiddleware
{
    /** @var array */
    private $allowedCidrs;

    public function __construct()
    {
        $this->allowedCidrs = [
            '10.0.0.0/8',
            '127.0.0.1/24',
            "172.0.0.0/8",   // docker local networking
            '192.168.0.0/16'
        ];
    }

    private function isAllowed()
    {
        $ipAddress = getClientIpAddress();
        $cidrMatch = new CIDRmatch();
        foreach ($this->allowedCidrs as $allowedCidr) {
            if ($cidrMatch->match($ipAddress, $allowedCidr) === true) {
                return true;
            }
        }

        return false;
    }


    public function __invoke(Request $request, ResponseInterface $response, $next)
    {
        if ($this->isAllowed() !== true) {
            $response = $response->withStatus(401);
            return $response;
        }

        return $next($request, $response);
    }
}
