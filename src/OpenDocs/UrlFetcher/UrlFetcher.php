<?php

declare(strict_types = 1);

namespace OpenDocs\UrlFetcher;

interface UrlFetcher
{
    public function getUrl(string $uri);
}
