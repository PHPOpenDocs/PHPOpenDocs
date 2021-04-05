<?php

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use Learning\LearningSection;
use OpenDocs\BreadcrumbsFactory;
use OpenDocs\CopyrightInfo;
use function Learning\getLearningContentLinks;
use OpenDocs\ExternalMarkdownRenderer\ExternalMarkdownRenderer;

$fn = function (
    LearningSection $section,
    BreadcrumbsFactory $breadcrumbsFactory,
    ExternalMarkdownRenderer $externalMarkdownRenderer
) {
    $url = "https://github.com/sarven/unit-testing-tips/raw/main/README.md";
    $html = $externalMarkdownRenderer->renderUrl($url);

    $contentLinks = getLearningContentLinks();

    $editInfo = createPHPOpenDocsEditInfo('Edit page', __FILE__, null);
    $editInfo->addNameWithLink("Edit content", "https://github.com/sarven/unit-testing-tips/raw/main/README.md");

    $page = \OpenDocs\Page::createFromHtmlEx2(
        'Unit testing tips',
        $html,
        $editInfo,
        $breadcrumbsFactory->createFromArray(['/unit_testing_tips' => 'Unit testing tips']),
        new CopyrightInfo(
            'sarven',
            'https://github.com/sarven/unit-testing-tips/blob/main/LICENSE'
        ),
        createLinkInfo('/unit_testing_tips', $contentLinks),
        $section
    );

    return $page;
};

showLearningResponse($fn);