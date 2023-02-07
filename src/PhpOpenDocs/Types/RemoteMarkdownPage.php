<?php

declare(strict_types = 1);

namespace PhpOpenDocs\Types;

class RemoteMarkdownPage
{
    public function __construct(private string $path)
    {
    }

    public function getEditUrl(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
}
