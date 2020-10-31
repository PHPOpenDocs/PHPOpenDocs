<?php

declare(strict_types = 1);

namespace OpenDocs;

/**
 * Links that go in the navigation section of the page.
 */
class Link
{
    private string $path;

    private string $description;

    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
}
