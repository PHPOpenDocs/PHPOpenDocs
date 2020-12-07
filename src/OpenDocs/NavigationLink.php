<?php

declare(strict_types = 1);

namespace OpenDocs;

/**
 * Links that go in the navigation section of the page.
 */
class NavigationLink
{
    private string $path;

    private string $description;

    /** @var array<NavigationLink>  */
    private $children = [];

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return array<NavigationLink>
     */
    public function getChildren(): array
    {
        return $this->children;
    }
}
