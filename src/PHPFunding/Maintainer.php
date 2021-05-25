<?php

declare(strict_types=1);


namespace PHPFunding;


class Maintainer
{
    private string $name;

    /** @var SponsorLink[] */
    private array $sponsorLinks = [];

    /**
     * Maintainer constructor.
     * @param string $name
     * @param array<string, string> $sponsorLinks
     */
    public function __construct(string $name, array $sponsorLinks)
    {
        $this->name = $name;
        foreach ($sponsorLinks as $name => $url) {
            $this->sponsorLinks[] = new SponsorLink($name, $url);
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return SponsorLink[]
     */
    public function getSponsorLinks(): array
    {
        return $this->sponsorLinks;
    }
}