<?php

declare(strict_types=1);


namespace PHPFunding;


class PHPExtension
{
    private string $name;

    /**
     * @var Maintainer[]
     */
    private array $maintainers = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }


    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Maintainer[]
     */
    public function getMaintainers(): array
    {
        return $this->maintainers;
    }

    /**
     * @param string $name
     * @param array<string, string> $sponsorUrls
     * @return $this
     */
    public function addMaintainer(string $name, array $sponsorLinks)
    {
        $this->maintainers[] = new Maintainer($name, $sponsorLinks);
        return $this;
    }
}