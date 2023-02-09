<?php

declare(strict_types = 1);

namespace PHPOpenDocs\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use ASVoting\Service\RequestNonce;
use ASVoting\Data\ApiDomain;

class ContentSecurityPolicyMiddleware
{
    /** @var RequestNonce */
    private $requestNonce;

    /** @var ApiDomain */
    private $apiDomain;

    public function __construct(
        RequestNonce $requestNonce,
        ApiDomain $apiDomain
    ) {
        $this->requestNonce = $requestNonce;
        $this->apiDomain = $apiDomain;
    }

    public function __invoke(Request $request, ResponseInterface $response, $next)
    {
        /** @var ResponseInterface $response  */
        $response = $next($request, $response);

        $connectSrcDomains = [
            'https://checkout.stripe.com',
            'https://api.stripe.com',
            $this->apiDomain->getDomain()
        ];

        $scriptSrcDomains = [
            'https://js.stripe.com/'
        ];

        $frameSrcDomains = [
            'https://js.stripe.com',
            'https://hooks.stripe.com',
        ];

        $cspLines = [];
        $cspLines[] = "default-src 'self'";
        $cspLines[] = sprintf(
            "connect-src 'self' %s",
            implode(' ', $connectSrcDomains)
        );

        $cspLines[] = sprintf(
            "frame-src 'self' %s",
            implode(' ', $frameSrcDomains)
        );

        $cspLines[] = "img-src * data:";
        $cspLines[] = sprintf(
            "script-src 'self' 'nonce-%s' %s",
            $this->requestNonce->getRandom(),
            implode(' ', $scriptSrcDomains)
        );
        $cspLines[] = "object-src *";
        $cspLines[] = "style-src 'self'";
        $cspLines[] = "report-uri /csp";

        $response = $response->withHeader(
            'Content-Security-Policy',
            implode("; ", $cspLines)
        );

        return $response;
    }
}
