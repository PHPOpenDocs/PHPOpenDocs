<?php

declare(strict_types = 1);

namespace OpenDocs;

/**
 * Used to display the edit links in the page footer.
 */
class EditInfo
{
    /**
     * @var array<string, string>
     */
    private array $namesWithLinks;

    private string $link;

    /**
     * @param array<string, string> $namesWithLinks
     */
    public function __construct(array $namesWithLinks)
    {
        $this->namesWithLinks = $namesWithLinks;
    }

    /**
     * @return array<string, string>
     */
    public function getNamesWithLinks(): array
    {
        return $this->namesWithLinks;
    }
}
