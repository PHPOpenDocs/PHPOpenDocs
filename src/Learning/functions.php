<?php

declare(strict_types = 1);

namespace Learning;

use Internals\InternalsSection;
use OpenDocs\BreadcrumbsFactory;
use OpenDocs\EditInfo;
use OpenDocs\ContentLink;
use OpenDocs\CopyrightInfo;
use OpenDocs\ExternalMarkdownRenderer\ExternalMarkdownRenderer;
use OpenDocs\MarkdownRenderer\MarkdownRenderer;
use OpenDocs\Page;
use function Internals\getInternalsContentLinks;

function getLearningContentLinks(): array
{
    return [
        ContentLink::level1(null, "Best practices"),
        ContentLink::level2('/best_practice_exceptions', 'Exceptions'),
        ContentLink::level2(
            '/best_practice_interfaces_for_external_apis',
            "Interfaces for external apis"
        ),
        ContentLink::level2(
            '/best_practice_shorts',
            "Best practice shorts"
        ),

        ContentLink::level1(null, "Library recommendations"),
        ContentLink::level2('/php_static_analysis_tools', 'Static analysis tools'),


        ContentLink::level1('/debugging', "Debugging"),
        ContentLink::level2('/debugging/xdebug.php', 'Xdebug'),
        ContentLink::level2('/debugging/gdb', 'GDB'),
        ContentLink::level2('/debugging/strace', 'Strace'),
        ContentLink::level2('/debugging/valgrind.php', 'Valgrind'),
        ContentLink::level2('/debugging/wireshark.php', 'Wireshark'),

        ContentLink::level1(null, "Good docs"),
        ContentLink::level2('/java_exception_antipatterns', "Java exception anti-patterns"),
    ];
}

function createEditInfo(string $description, string $file, ?int $line): EditInfo
{
    $path = normaliseFilePath($file);

    $link = 'https://github.com/PHPOpenDocs/PHPOpenDocs/blob/main/' . $path;

    if ($link !== null) {
        $link .= '#L' . $line;
    }

    return new EditInfo([$description => $link]);
}

function createLearningDefaultCopyrightInfo()
{
    return new CopyrightInfo(
        'PHP OpenDocs',
        'https://github.com/PHPOpenDocs/PHPOpenDocs/blob/main/LICENSE'
    );
}





function createPageFn(
    string $markdown_path,
    string $title,
    string $current_path
) {
    $breadcrumbs = [$current_path => $title];

    return function (
        InternalsSection $section,
        MarkdownRenderer $markdownRenderer,
        BreadcrumbsFactory $breadcrumbsFactory
    ) use (
        $markdown_path,
        $title,
        $breadcrumbs,
        $current_path
    ) {
        $fullPath = $markdown_path;
        $html = $markdownRenderer->renderFile($fullPath);

        $contentLinks = getLearningContentLinks();
        $editInfo = createPHPOpenDocsEditInfo('Edit page', __FILE__, null);

        $page = Page::createFromHtmlEx2(
            $title,
            $html,
            $editInfo,
            $breadcrumbsFactory->createFromArray($breadcrumbs),
            createLearningDefaultCopyrightInfo(),
            createLinkInfo($current_path, $contentLinks),
            $section
        );

        return $page;
    };
}


function createRemoteMarkdownPageFn(
    string $markdown_url,
    string $title,
    string $current_path,
    CopyrightInfo $copyright_info
) {
    $breadcrumbs = [$current_path => $title];

    return function (
        InternalsSection $section,
        ExternalMarkdownRenderer $markdownRenderer,
        BreadcrumbsFactory $breadcrumbsFactory
    ) use (
        $markdown_url,
        $title,
        $breadcrumbs,
        $current_path,
        $copyright_info
    ) {

        $html = $markdownRenderer->renderUrl($markdown_url);

        $contentLinks = getInternalsContentLinks();
        $editInfo = createPHPOpenDocsEditInfo('Edit page', __FILE__, null);

        $page = Page::createFromHtmlEx2(
            $title,
            $html,
            $editInfo,
            $breadcrumbsFactory->createFromArray($breadcrumbs),
            $copyright_info,
            createLinkInfo($current_path, $contentLinks),
            $section
        );

        return $page;
    };
}
