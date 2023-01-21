<?php

declare(strict_types = 1);

namespace OpenDocs\SiteHtml;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ResponseFactoryInterface as ResponseFactory;
use OpenDocs\AssetLinkEmitter;

class PageResponseGenerator
{
    public function __construct(
        private ResponseFactory $responseFactory,
        private AssetLinkEmitter $assetLinkEmitter
    ) {
    }

    public function createPageWithStatusCode(
        $contentHtml,
        $statusCode
    ): Response {

        $page = createErrorPage(nl2br($contentHtml));
//        $page = createPageHtml($this->assetLinkEmitter, $contentHtml);
        $page = createPageHtml(null, $page);

        $response = $this->responseFactory->createResponse();
        $response = $response->withHeader('Content-Type', 'text/html');
        $response->getBody()->write($page);

        $response = $response->withStatus($statusCode);

        return $response;
    }
}
