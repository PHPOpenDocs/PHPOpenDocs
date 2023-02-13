<?php

declare(strict_types = 1);

namespace SiteChecker;

class Link
{
    public function __construct(private string $caption, private string $href)
    {
    }

    /**
     * @return string
     */
    public function getCaption(): string
    {
        return $this->caption;
    }

    /**
     * @return string
     */
    public function getHref(): string
    {
        return $this->href;
    }
}
