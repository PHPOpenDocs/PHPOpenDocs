<?php

declare(strict_types = 1);

namespace OpenDocs\UrlFetcher;

class CurlUrlFetcher implements UrlFetcher
{
    public function getUrl(string $uri)
    {
        [$statusCode, $body, $headers] = \fetchUri(
            $uri,
            $method = 'GET',
            $queryParams = [],
            $body = null,
            $headers = []
        );

        if ($statusCode !== 200) {
            UrlFetcherException::notOk($statusCode);
        }

        return $body;
    }
}
