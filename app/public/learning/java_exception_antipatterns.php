<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use Learning\LearningSection;
use OpenDocs\CopyrightInfo;
use OpenDocs\MarkdownRenderer\MarkdownRenderer;
use OpenDocs\BreadcrumbsFactory;
use function Learning\getLearningContentLinks;

$fn = function (
    LearningSection $section,
    MarkdownRenderer $markdownRenderer,
    BreadcrumbsFactory $breadcrumbsFactory
) {
    $fullPath = __DIR__ . "/../../../src/Learning/docs/archive_java_exception_antipatterns.md";
    $html = $markdownRenderer->renderFile($fullPath);

    $contentLinks = getLearningContentLinks();

    $page = \OpenDocs\Page::createFromHtmlEx2(
        'Java Exception Antipatterns',
        $html,
        createPHPOpenDocsEditInfo('Edit page', __FILE__, null),
        $breadcrumbsFactory->createFromArray([
            '/java_exception_antipatterns' => 'Java Exception Antipatterns'
        ]),
        new CopyrightInfo(
            'Tim McCune',
            'https://github.com/Danack/RfcCodex/blob/master/LICENSE'
        ),
        createLinkInfo('/java_exception_antipatterns', $contentLinks),
        $section
    );

    return convertPageToHtmlResponse($section, $page);
};

showLearningResponse($fn);