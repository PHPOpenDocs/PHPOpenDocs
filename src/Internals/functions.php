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
use OpenDocs\GlobalPageInfo;
use OpenDocs\MarkdownRenderer\PackageMarkdownRenderer;
use PhpOpenDocs\Types\PackageMarkdownPage;
use PhpOpenDocs\Types\RemoteMarkdownPage;

function createGlobalPageInfoForInternals(
    string $html = null,
    string $title = null
) {
    GlobalPageInfo::create(
        contentHtml: $html,
        contentLinks: getInternalsContentLinks(),
        copyrightInfo: createInternalsDefaultCopyrightInfo(),
        section: \Internals\InternalsSection::create(),
        title: $title,
        current_path: getRequestPath(),
    );
}

function createGlobalPageInfo2(
    CopyrightInfo $copyrightInfo,
    EditInfo $editInfo
) {
    GlobalPageInfo::create(
        contentLinks: getInternalsContentLinks(),
        copyrightInfo: $copyrightInfo,
        section: \Internals\InternalsSection::create(),
        editInfo: $editInfo
    );
}


function createMarkdownPackagePageFnInternals(
    PackageMarkdownPage $packageMarkdownPage,
    string $title,
) {
    createGlobalPageInfoForInternals();

    GlobalPageInfo::addMarkDownEditInfo("Edit content", $packageMarkdownPage);
    GlobalPageInfo::addEditInfoFromBacktrace('Edit page', 1);
    GlobalPageInfo::setTitleFromCurrentPath();
    GlobalPageInfo::setBreadcrumbsFromArray(["blah" /*$current_path*/ => $title]);

    return function (
        PackageMarkdownRenderer $markdownRenderer
    ) use (
        $packageMarkdownPage,
    ) {
        $html = $markdownRenderer->render($packageMarkdownPage);

        GlobalPageInfo::setContentHtml($html);

        return \OpenDocs\Page::createFromHtmlGlobalPageInfo();
    };
}

function createRemoteMarkdownPageFn(
    RemoteMarkdownPage $remoteMarkdownPage,
    string $title,
    CopyrightInfo $copyright_info
) {
    createGlobalPageInfoForInternals();

    GlobalPageInfo::addRemoteMarkDownEditInfo("Edit content", $remoteMarkdownPage);
    GlobalPageInfo::addEditInfoFromBacktrace('Edit page', 1);
    GlobalPageInfo::setTitle($title);
//    $gPageInfo->setCurrentPath($current_path);
    GlobalPageInfo::setTitleFromCurrentPath();
//    $gPageInfo->setBreadcrumbsFromArray([$current_path => $title]);

    GlobalPageInfo::addCopyrightInfo($copyright_info);

    return function (
        ExternalMarkdownRenderer $markdownRenderer,
    ) use (
        $remoteMarkdownPage,
    ) {

        $markdown_url = $remoteMarkdownPage->getEditUrl();
        $html = $markdownRenderer->renderUrl($markdown_url);

        GlobalPageInfo::setContentHtml($html);

        return \OpenDocs\Page::createFromHtmlGlobalPageInfo();
    };
}

/**
 * @param string $markdown_url
 * @param string $title
 * @param string $current_path
 * @param CopyrightInfo $copyright_info
 * @param \OpenDocs\EditInfo[] $editInfoArray
 * @return \Closure
 */
function createRemoteMarkdownPageFnEx(
    RemoteMarkdownPage $remoteMarkdownPage,
    string $title,
    string $current_path,
    CopyrightInfo $copyright_info,
    EditInfo $editInfo
) {
    \Internals\createGlobalPageInfo2($copyright_info, $editInfo);

    GlobalPageInfo::addEditInfoFromBacktrace('Edit page', 1);
    GlobalPageInfo::setTitle($title);
    GlobalPageInfo::setCurrentPath($current_path);
    GlobalPageInfo::setBreadcrumbsFromArray([$current_path => $title]);

    return function (
        ExternalMarkdownRenderer $markdownRenderer,
    ) use (
        $remoteMarkdownPage,
        $title,
    ) {
        $markdown_url = $remoteMarkdownPage->getEditUrl();
        $html = $markdownRenderer->renderUrl($markdown_url);

        GlobalPageInfo::setContentHtml($html);

        return \OpenDocs\Page::createFromHtmlGlobalPageInfo();
    };
}



function getInternalsContentLinks(): array
{
    return [
        ContentLink::level1(null, "Technical"),
        ContentLink::level2('/', 'Overview of resources here'),
        ContentLink::level2('/useful_links', 'Links to elsewhere'),
        ContentLink::level2('/php_parameter_parsing', 'PHP Parameter parsing'),
        ContentLink::level2('/php_contributing', 'Contributing to PHP'),

        ContentLink::level1(null, "Etiquette"),
        ContentLink::level2('/mailing_list', 'Mailing list etiquette'),
        ContentLink::level2('/mailing_list_for_younguns', 'Mailing list etiquette for young\'uns'),
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

function createInternalsDefaultCopyrightInfo(): CopyrightInfo
{
    return new CopyrightInfo(
        'PHP OpenDocs',
        'https://github.com/PHPOpenDocs/PHPOpenDocs/blob/main/LICENSE'
    );
}
