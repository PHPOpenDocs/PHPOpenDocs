<?php

declare(strict_types = 1);

namespace OpenDocs;

class ContentLink
{
    private ?string $path;

    private string $description;

    private int $level;

    /**
     *
     * @param string|null $path
     * @param string $description
     * @param int $level
     */
    private function __construct(
        ?string $path,
        string $description,
        int $level
    ) {
        $this->path = $path;
        $this->description = $description;
        $this->level = $level;
    }

    public static function level1(?string $path, string $description)
    {
        return new self($path, $description, 1);
    }

    public static function level2(?string $path, string $description)
    {
        return new self($path, $description, 2);
    }

    public static function level3(?string $path, string $description)
    {
        return new self($path, $description, 3);
    }

    /**
     * @return string|null
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }
}
