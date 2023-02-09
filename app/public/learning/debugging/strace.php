<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../../src/web_bootstrap.php";

use Learning\LearningSection;
use OpenDocs\Page;
use OpenDocs\MarkdownRenderer\MarkdownRenderer;
use function Learning\getLearningContentLinks;
use function Learning\createLearningDefaultCopyrightInfo;

$fn = function (
    LearningSection $section,
    MarkdownRenderer $markdownRenderer,
    \OpenDocs\BreadcrumbsFactory $breadcrumbsFactory
) : Page {

    $fullPath = __DIR__ . "/../../../../src/Learning/docs/strace.md";
    $html = $markdownRenderer->renderFile($fullPath);

    $contentLinks = getLearningContentLinks();

    $page = Page::createFromHtmlEx2(
        'Debugging',
        $html,
        createPHPOpenDocsEditInfo('Edit page', __FILE__, null),
        $breadcrumbsFactory->createFromArray([]),
        createLearningDefaultCopyrightInfo(),
        createLinkInfo('/', $contentLinks),
        $section
    );

    return $page;
};

showResponse($fn);
