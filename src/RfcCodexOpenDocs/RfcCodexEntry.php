<?php

declare(strict_types = 1);

namespace RfcCodexOpenDocs;

class RfcCodexEntry
{
    private string $name;

    private string $filename;

    /**
     *
     * @param string $name
     * @param string $path
     */
    public function __construct(
        string $name,
        string $path
    ) {
        $this->name = $name;
        $this->filename = $path;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function getPath()
    {
        return '/' . pathinfo($this->filename, PATHINFO_FILENAME);
    }
}
