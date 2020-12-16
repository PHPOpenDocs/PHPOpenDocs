<?php

declare(strict_types = 1);

namespace OpenDocs;

class FooterInfo
{
    private string $copyrightName;

    private string $editLink;

    /**
     *
     * @param string $copyrightName
     * @param string $editLink
     */
    public function __construct(
        string $copyrightName,
        string $editLink
    ) {
        $this->copyrightName = $copyrightName;
        $this->editLink = $editLink;
    }

    /**
     * @return string
     */
    public function getCopyrightName(): string
    {
        return $this->copyrightName;
    }

    /**
     * @return string
     */
    public function getEditLink(): string
    {
        return $this->editLink;
    }
}
