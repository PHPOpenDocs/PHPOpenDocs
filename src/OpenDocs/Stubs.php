<?php

declare(strict_types = 1);

namespace OpenDocs;

class Stubs
{
    /** @var Stub[] $stubs */
    private $stubs;

    /**
     *
     * @param Stub[] $stubs
     */
    public function __construct(array $stubs)
    {
        $this->stubs = $stubs;
    }

    /**
     * @return Stub[]
     */
    public function getStubs(): array
    {
        return $this->stubs;
    }
}
