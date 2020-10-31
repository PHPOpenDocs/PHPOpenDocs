<?php

declare(strict_types = 1);

namespace OpenDocs;

class Stub
{
    private string $text;

    private string $pathFragment;

    public function __construct(
        string $text,
        string $pathFragment
    ) {
        $this->text = $text;
        $this->pathFragment = $pathFragment;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getPathFragment(): string
    {
        return $this->pathFragment;
    }
}
