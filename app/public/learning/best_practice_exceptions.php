<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use Learning\LearningSection;

use OpenDocs\MarkdownRenderer\MarkdownRenderer;
use OpenDocs\BreadcrumbsFactory;
use function Learning\getLearningContentLinks;
use function Learning\createLearningDefaultCopyrightInfo;

$fn = function (
    LearningSection $section,
    MarkdownRenderer $markdownRenderer,
    BreadcrumbsFactory $breadcrumbsFactory
) {
    $fullPath = __DIR__ . "/../../../src/Learning/docs/best_practice_exceptions.md";
    $html = $markdownRenderer->renderFile($fullPath);

    $contentLinks = getLearningContentLinks();
    $editInfo = createPHPOpenDocsEditInfo('Edit page', __FILE__, null);
    //$editInfo->addNameWithLink('edit content', best_practice_exceptions.md);

    $page = \OpenDocs\Page::createFromHtmlEx2(
        'Best practice exceptions',
        $html,
        $editInfo,
        $breadcrumbsFactory->createFromArray([
            '/best_practice_exceptions' => 'Best practice exceptions'
        ]),
        createLearningDefaultCopyrightInfo(),
        createLinkInfo('/best_practice_exceptions', $contentLinks),
        $section
    );

    return $page;
    //return convertPageToHtmlResponse($section, $page);
};

showLearningResponse($fn);