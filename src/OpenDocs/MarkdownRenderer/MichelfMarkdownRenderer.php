<?php

declare(strict_types = 1);

namespace OpenDocs\MarkdownRenderer;

use Michelf\MarkdownExtra;

class MichelfMarkdownRenderer implements MarkdownRenderer
{
    public function render(string $markdown): string
    {
        echo "fuck computers";
        exit(-1);
        return MarkdownExtra::defaultTransform($markdown);
    }
}
