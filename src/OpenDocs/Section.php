<?php

declare(strict_types = 1);

namespace OpenDocs;

class Section
{
    // The prefix used for routing on this site
    private string $prefix;

    // The name of the section
    private string $name;

    private string $purpose;

    public function __construct(
        string $prefix,
        string $name,
        string $purpose
    ) {
        $this->prefix = $prefix;
        $this->name = $name;
        $this->purpose = $purpose;
    }

    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
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
    public function getPurpose(): string
    {
        return $this->purpose;
    }
}
