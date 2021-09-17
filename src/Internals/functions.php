<?php

declare(strict_types = 1);

namespace Internals;

use OpenDocs\EditInfo;
use OpenDocs\ContentLink;
use OpenDocs\CopyrightInfo;
use OpenDocs\MarkdownRenderer\MarkdownRenderer;
use OpenDocs\ExternalMarkdownRenderer\ExternalMarkdownRenderer;
use OpenDocs\BreadcrumbsFactory;
use OpenDocs\Page;

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

        $contentLinks = getInternalsContentLinks();
        $editInfo = createPHPOpenDocsEditInfo('Edit page', __FILE__, null);

        $page = Page::createFromHtmlEx2(
            $title,
            $html,
            $editInfo,
            $breadcrumbsFactory->createFromArray($breadcrumbs),
            createInternalsDefaultCopyrightInfo(),
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


function getInternalsContentLinks(): array
{
    return [

        ContentLink::level1(null, "Technical"),
        ContentLink::level2('/php_parameter_parsing', 'PHP Parameter parsing'),
        ContentLink::level2('/php_contributing', 'Contributing to PHP'),

        ContentLink::level1(null, "Etiquette"),
        ContentLink::level2('/mailing_list', 'Mailing list etiquette'),
        ContentLink::level2('/rfc_attitudes', 'RFC attitudes'),
        ContentLink::level2('/rfc_etiquette', 'RFC etiquette'),


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

function createInternalsDefaultCopyrightInfo()
{
    return new CopyrightInfo(
        'PHP OpenDocs',
        'https://github.com/PHPOpenDocs/PHPOpenDocs/blob/main/LICENSE'
    );
}
