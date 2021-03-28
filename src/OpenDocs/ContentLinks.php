<?php

declare(strict_types = 1);

namespace OpenDocs;


class ContentLinks
{
    /** @var ContentLink[]  */
    private array $links;

    /**
     *
     * @param ContentLink[] $children
     */
    public function __construct(array $children)
    {
        $this->links = $children;
    }

    public static function createEmpty()
    {
        return new self([]);
    }

    /**
     * @return ContentLink[]
     */
    public function getLinks(): array
    {
        return $this->links;
    }
}
