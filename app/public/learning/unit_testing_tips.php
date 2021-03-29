<?php

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use Learning\LearningSection;
use OpenDocs\Breadcrumbs;

use OpenDocs\CopyrightInfo;
use function Learning\getLearningContentLinks;
use OpenDocs\ExternalMarkdownRenderer\ExternalMarkdownRenderer;

$fn = function (
    LearningSection $section,
    ExternalMarkdownRenderer $externalMarkdownRenderer
) {
    $url = "https://github.com/sarven/unit-testing-tips/raw/main/README.md";
    $html = $externalMarkdownRenderer->renderUrl($url);

    $contentLinks = getLearningContentLinks();

    $page = \OpenDocs\Page::createFromHtmlEx2(
        'Unit testing tips',
        $html,
        createPHPOpenDocsEditInfo('Edit page', __FILE__, null),
        Breadcrumbs::fromArray([
            '/unit_testing_tips' => 'Unit testing tips'
        ]),
        new CopyrightInfo(
            'sarven',
            'https://github.com/sarven/unit-testing-tips/blob/main/LICENSE'
        ),
        createLinkInfo('/unit_testing_tips', $contentLinks)
    );

    return convertPageToHtmlResponse($section, $page);
};

showResponse($fn);