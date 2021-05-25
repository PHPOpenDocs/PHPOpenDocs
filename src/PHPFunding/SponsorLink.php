<?php

declare(strict_types=1);


namespace PHPFunding;


class SponsorLink
{
    // The name of the sponsor service. e.g. github gittips.
    private string $name;

    // The link to the page
    private string $url;

    public function __construct(string $name, string $url)
    {
        $this->name = $name;
        $this->url = $url;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}