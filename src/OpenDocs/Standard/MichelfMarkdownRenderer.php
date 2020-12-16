<?php

declare(strict_types = 1);

namespace OpenDocs\Standard;

use Michelf\MarkdownExtra;
use OpenDocs\MarkdownRenderer;

class MichelfMarkdownRenderer implements MarkdownRenderer
{
    public function render(string $markdown): string
    {
        return MarkdownExtra::defaultTransform($markdown);
    }
}
