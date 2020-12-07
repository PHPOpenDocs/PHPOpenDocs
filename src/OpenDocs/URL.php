<?php

declare(strict_types = 1);

namespace OpenDocs;

class URL
{
    private string $url;

    public function __construct(string $url)
    {
        // TODO - test for validity
        $this->url = $url;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
