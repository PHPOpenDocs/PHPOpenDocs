<?php

declare(strict_types = 1);

namespace OpenDocs;

class CopyrightInfo
{
    /**
     * @var array<string, string>
     */
    private array $namesWithLinks = array();


    public function __construct()
    {
    }

    public static function create(
        string $name,
        string $link
    ): self {
        $instance = new self();
        $instance->namesWithLinks[$name] = $link;

        return $instance;
    }

    public static function createEmpty(): self
    {
        return new self();
    }

    /**
     * @return array<string, string>
     */
    public function getNamesWithLinks(): array
    {
        return $this->namesWithLinks;
    }

    public function addNameWithLink(string $name, string $url): void
    {
        $this->namesWithLinks[$name] = $url;
    }
}
