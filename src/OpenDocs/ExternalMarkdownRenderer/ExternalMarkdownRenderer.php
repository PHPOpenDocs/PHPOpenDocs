<?php

declare(strict_types = 1);

namespace OpenDocs\ExternalMarkdownRenderer;

interface ExternalMarkdownRenderer
{
    public function renderUrl(string $url): string;
}
