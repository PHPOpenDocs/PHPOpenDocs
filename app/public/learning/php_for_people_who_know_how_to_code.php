<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use Learning\LearningSection;
use OpenDocs\Breadcrumbs;
use OpenDocs\MarkdownRenderer\MarkdownRenderer;
use OpenDocs\BreadcrumbsFactory;
use function Learning\getLearningContentLinks;
use function Learning\createLearningDefaultCopyrightInfo;

$fn = function (
    LearningSection $section,
    MarkdownRenderer $markdownRenderer,
    BreadcrumbsFactory $breadcrumbsFactory
) {
    $fullPath = __DIR__ . "/../../../src/Learning/docs/php_for_people_who_know_how_to_code.md";
    $html = $markdownRenderer->renderFile($fullPath);

    $contentLinks = getLearningContentLinks();

    $page = \OpenDocs\Page::createFromHtmlEx2(
        'Best practice exceptions',
        $html,
        createPHPOpenDocsEditInfo('Edit page', __FILE__, null),
        Breadcrumbs::fromArray([
            '/php_for_people_who_know_how_to_code' => 'PHP for people who know how to program'
        ]),
        createLearningDefaultCopyrightInfo(),
        createLinkInfo('/php_for_people_who_know_how_to_code', $contentLinks),
        $section
    );

    return $page;
};

showResponse($fn);