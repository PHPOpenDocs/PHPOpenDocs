<?php

declare(strict_types = 1);

namespace PHPFunding;

class PHPPerson
{
    private string $name;

    /** @var WorkItem[] */
    private array $workItems_8_0 = [];

    /** @var WorkItem[] */
    private array $workItems_8_1 = [];

    private ?string $githubSponsor = null;

    /**
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function addRfc_8_0(string $url, string $name)
    {
        $this->workItems_8_0[] = new Rfc($name, $url);
        return $this;
    }

    public function addRfc_8_1(string $url, string $name)
    {
        $this->workItems_8_1[] = new Rfc($name, $url);
        return $this;
    }


    public function addGithubSponsor(string $url)
    {
        $this->githubSponsor = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return WorkItem[]
     */
    public function getWorkItems_8_0(): array
    {
        return $this->workItems_8_0;
    }

    /**
     * @return WorkItem[]
     */
    public function getWorkItems_8_1(): array
    {
        return $this->workItems_8_1;
    }



    /**
     * @return string|null
     */
    public function getGithubSponsor(): ?string
    {
        return $this->githubSponsor;
    }
}
