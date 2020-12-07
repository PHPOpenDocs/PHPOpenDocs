<?php

declare(strict_types = 1);

namespace OpenDocs;

class PrevNextLinks
{
    private ?Link $prevLink;

    private ?Link $nextLink;

    public function __construct(
        ?Link $prev,
        ?Link $next
    ) {
        $this->prevLink = $prev;
        $this->nextLink = $next;
    }

    public function getPrevLink(): ?Link
    {
        return $this->prevLink;
    }

    public function getNextLink(): ?Link
    {
        return $this->nextLink;
    }
}
