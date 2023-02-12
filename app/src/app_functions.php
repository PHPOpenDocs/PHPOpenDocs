<?php

use OpenDocs\ExternalMarkdownRenderer\ExternalMarkdownRenderer;
use OpenDocs\GlobalPageInfo;
use OpenDocs\MarkdownRenderer\PackageMarkdownRenderer;
use OpenDocs\Section;
use PHPOpenDocs\Types\PackageMarkdownPage;
use PHPOpenDocs\Types\RemoteMarkdownPage;
use function Learning\createGlobalPageInfoForLearning;

function getRequestPath(): string
{
    return $_SERVER["REQUEST_URI"];
}

function getRequestPathWithoutSection(\OpenDocs\Section $section): string
{
    $requestPath = getRequestPath();

    $prefix = $section->getPrefix();

    if (str_starts_with($requestPath, $prefix) === true) {
        return substr($requestPath, strlen($prefix));
    }

    return $requestPath;
}

function createRemoteMarkdownPageFnSectionFree(
    RemoteMarkdownPage $remoteMarkdownPage,
): callable {
    GlobalPageInfo::addRemoteMarkDownEditInfo("Edit content", $remoteMarkdownPage);
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

function createMarkdownPackagePageFnSectionFree(
    PackageMarkdownPage $packageMarkdownPage
): callable {

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