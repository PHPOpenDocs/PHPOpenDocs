<?php

declare(strict_types = 1);

namespace RfcCodexOpenDocs;

use OpenDocs\GlobalPageInfo;
use OpenDocs\MarkdownRenderer\MarkdownRenderer;
use OpenDocs\Page;
use function \Safe\preg_replace;

class Pages
{
    private MarkdownRenderer $markdownRenderer;

    public function __construct(MarkdownRenderer $markdownRenderer)
    {
        $this->markdownRenderer = $markdownRenderer;
    }

    private function getContents(string $name): ?string
    {
        $name = preg_replace("#([^a-zA-Z_])*#iu", "", $name);
        $fullPath = __DIR__ . "/../../vendor/danack/rfc-codex/" . $name . ".md";

        $contents = @file_get_contents($fullPath);
        if ($contents !== false) {
            return $this->markdownRenderer->render($contents);
        }
        return null;
    }

    public function getPage(string $name): Page
    {
        $contents = $this->getContents($name);
        if ($contents === null) {
            // TODO
            $contents = "This should be a 404 page.";
            exit(0);
        }
        $codexEntry = getCodexEntry($name);
        $title = $codexEntry->getName();

        createGlobalPageInfoForRfcCodex(
            title: $title,
            html: $contents
        );


        GlobalPageInfo::addCopyrightInfoFromStrings(
            'Danack',
            'https://github.com/Danack/RfcCodex/blob/master/LICENSE'
        );

        GlobalPageInfo::addEditInfoFromStrings(
            'Edit content',
            'https://github.com/Danack/RfcCodex/blob/master/' . $codexEntry->getFilename()
        );

        return \OpenDocs\Page::createFromHtmlGlobalPageInfo();
    }
}
