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

    public function addNameWithLink(string $name, string $link): void
    {
        $this->namesWithLinks[$name] = $link;
    }

    public function addEditInfo(EditInfo $editInfo): void
    {
        foreach ($editInfo->getNamesWithLinks() as $name => $link) {
            $this->namesWithLinks[$name] = $link;
        }
    }
}
