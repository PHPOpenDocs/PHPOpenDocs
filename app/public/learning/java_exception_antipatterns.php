<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use Learning\LearningSection;
use OpenDocs\Breadcrumbs;
use OpenDocs\ContentLink;
use OpenDocs\CopyrightInfo;
use OpenDocs\MarkdownRenderer\MarkdownRenderer;
use function Learning\getLearningContentLinks;


$fn = function (
    LearningSection $section,
    MarkdownRenderer $markdownRenderer
) {
    $fullPath = __DIR__ . "/../../../src/Learning/docs/archive_java_exception_antipatterns.md";
    $html = $markdownRenderer->renderFile($fullPath);

    $contentLinks = getLearningContentLinks();

    $page = \OpenDocs\Page::createFromHtmlEx2(
        'Java Exception Antipatterns',
        $html,
        createPHPOpenDocsEditInfo('Edit page', __FILE__, null),
        Breadcrumbs::fromArray([
            '/java_exception_antipatterns' => 'Java Exception Antipatterns'
        ]),
        new CopyrightInfo(
            'Tim McCune',
            'https://github.com/Danack/RfcCodex/blob/master/LICENSE'
        ),
        createLinkInfo('/java_exception_antipatterns', $contentLinks)
    );

    return convertPageToHtmlResponse($section, $page);
};

showResponse($fn);