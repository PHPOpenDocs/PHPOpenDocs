<?php

declare(strict_types = 1);


namespace OpenDocs;


interface MarkdownRenderer
{
    public function render(string $markdown): string;
}