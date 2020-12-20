<?php

declare(strict_types = 1);

namespace PHPFunding;

class PHPPerson
{
    private string $name;

    /** @var WorkItem[] */
    private array $workItems = [];

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
        $this->workItems[] = new Rfc($name, $url);
        return $this;
    }

    public function addWorkItem(WorkItem $workItem): self
    {
        $this->workItems[] = $workItem;
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
    public function getWorkItems(): array
    {
        return $this->workItems;
    }

    /**
     * @return string|null
     */
    public function getGithubSponsor(): ?string
    {
        return $this->githubSponsor;
    }
}
