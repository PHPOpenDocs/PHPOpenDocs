<?php

namespace OpenDocs;

class RequestPath
{
    public function __construct(private string $path)
    {
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
}
