<?php

declare(strict_types = 1);

namespace PHPFunding;

class Rfc implements WorkItem
{
    private string $name;

    private string $url;

    /**
     *
     * @param string $name
     * @param string $url
     */
    public function __construct(
        string $name,
        string $url
    ) {
        $this->name = $name;
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->name;
    }


    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }
}
