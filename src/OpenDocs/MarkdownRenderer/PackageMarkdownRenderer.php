<?php

namespace OpenDocs\MarkdownRenderer;

use PhpOpenDocs\Types\PackageMarkdownPage;

class PackageMarkdownRenderer
{
    public function __construct(private MarkdownRenderer $markdownRenderer)
    {
    }

    public function render(PackageMarkdownPage $packageMarkdownPage): string
    {

        $full_path = sprintf(
            "%s/%s",
            $packageMarkdownPage->getPathToPackage(),
            $packageMarkdownPage->getPath()
        );

        return $this->markdownRenderer->renderFile($full_path);
    }
}