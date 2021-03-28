<?php

declare(strict_types = 1);

namespace OpenDocs;

class LinkInfo
{
    private PrevNextLinks $prevNextLinks;

    private ContentLinks $contentLinks;

    /**
     *
     * @param PrevNextLinks $prevNextLinks
     * @param ContentLink[] $contentLinks
     */
    public function __construct(
        PrevNextLinks $prevNextLinks,
        ContentLinks $contentLinks
    ) {
        $this->prevNextLinks = $prevNextLinks;
        $this->contentLinks = $contentLinks;
    }


    public function getPrevNextLinks(): PrevNextLinks
    {
        return $this->prevNextLinks;
    }

    /**
     * @return ContentLink[]
     */
    public function getContentLinks(): array
    {
        return $this->contentLinks;
    }
}
