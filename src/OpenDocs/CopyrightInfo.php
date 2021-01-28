<?php

declare(strict_types = 1);

namespace OpenDocs;

class CopyrightInfo
{
    private string $name;

    private string $link;

    /**
     *
     * @param string $name
     * @param string $link
     */
    public function __construct(
        string $name,
        string $link
    ) {
        $this->name = $name;
        $this->link = $link;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }
}
