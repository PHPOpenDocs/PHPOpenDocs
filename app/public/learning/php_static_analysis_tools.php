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
    $url = "https://raw.githubusercontent.com/exakat/php-static-analysis-tools/master/README.md";
    $html = $externalMarkdownRenderer->renderUrl($url);

    $contentLinks = getLearningContentLinks();

    $editInfo = createPHPOpenDocsEditInfo('Edit page', __FILE__, __LINE__ - 5);
    $editInfo->addNameWithLink(
        "Edit content",
        "https://github.com/exakat/php-static-analysis-tools/blob/master/README.md"
    );

    $page = \OpenDocs\Page::createFromHtmlEx2(
        'PHP static analysis_tools',
        $html,
        $editInfo,
        $breadcrumbsFactory->createFromArray([
            '/php_static_analysis_tools' => 'PHP static analysis_tools'
        ]),
        new CopyrightInfo(
            'exakat',
            'https://github.com/exakat/php-static-analysis-tools/blob/master/LICENSE.md'
        ),
        createLinkInfo('/php_static_analysis_tools', $contentLinks),
        $section
    );

    return $page;
};

showLearningResponse($fn);