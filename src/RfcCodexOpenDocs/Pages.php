<?php

declare(strict_types = 1);

namespace RfcCodexOpenDocs;

use OpenDocs\Breadcrumb;
use OpenDocs\Breadcrumbs;
use OpenDocs\CopyrightInfo;
use OpenDocs\MarkdownRenderer\MarkdownRenderer;
use OpenDocs\Page;
use OpenDocs\PrevNextLinks;
use OpenDocs\ContentLink;
use RfcCodexOpenDocs\RfcCodexSection;
use function RfcCodexOpenDocs\getAchievedList;
use function RfcCodexOpenDocs\getUnderDiscussionList;
use function \Safe\preg_replace;

class Pages
{
    private MarkdownRenderer $markdownRenderer;

    public function __construct(MarkdownRenderer $markdownRenderer)
    {
        $this->markdownRenderer = $markdownRenderer;
    }


    /**
     * @return ContentLink[]
     */
    public function getContentLinks(): array
    {
        $links = [];

        $links[] = ContentLink::level1(null, 'Under discussion');

        foreach (getUnderDiscussionList() as $under_discussion_entry) {
            $links[] = ContentLink::level2(
                '/' . $under_discussion_entry->getPath(),
                $under_discussion_entry->getName()
            );
        }

        $links[] = ContentLink::level1(null, 'Ideas that overcame their challenges');

        foreach (getAchievedList() as $achieved_entry) {
            $links[] = ContentLink::level2(
                '/' . $achieved_entry->getPath(),
                $achieved_entry->getName()
            );
        }

        return $links;
    }

    private function getContents($name): ?string
    {
        $name = preg_replace("#([^a-zA-Z_])*#iu", "", $name);
        $fullPath = __DIR__ . "/../../vendor/danack/rfc-codex/" . $name . ".md";

        $contents = @file_get_contents($fullPath);
        if ($contents !== false) {
            return $this->markdownRenderer->render($contents);
        }
        return null;
    }

    public function getPage(RfcCodexSection $section, $name): Page
    {
        $contents = $this->getContents($name);

        if ($contents === null) {
            // TODO
            $contents = "This should be a 404 page.";
        }

        $title = getTitleFromFileName($name);

        return new Page(
            'RFC Codex - ' . $title,
            createDefaultEditInfo(),
            getRfcCodexContentLinks(),
            createPrevNextLinksFromContentLinks(getRfcCodexContentLinks(), $name),
            $contents,
            new CopyrightInfo('Danack', 'https://github.com/Danack/RfcCodex/blob/master/LICENSE'),
            $breadcrumbs = new Breadcrumbs(new Breadcrumb($name, $title)),
            $section
        );
    }

    public function getIndexPage(RfcCodexSection $section): Page
    {
        $fullPath = __DIR__ . "/../../vendor/danack/rfc-codex/rfc_codex.md";
        $markdown = file_get_contents($fullPath);
        $contents = $this->markdownRenderer->render($markdown);

        $contents = str_replace(
            "https://github.com/Danack/RfcCodex/blob/master",
            $section->getPrefix(),
            $contents
        );

        return new Page(
            'Rfc Codex',
            createDefaultEditInfo(),
            getRfcCodexContentLinks(),
            new PrevNextLinks(null, null),
            $contents,
            new CopyrightInfo('Danack', 'https://github.com/Danack/RfcCodex/blob/master/LICENSE'),
            $breadcrumbs = new Breadcrumbs(),
            $section
        );
    }
}
