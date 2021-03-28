<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use Learning\LearningSection;
use OpenDocs\Breadcrumbs;
use OpenDocs\ContentLink;
use OpenDocs\ContentLinks;
use OpenDocs\CopyrightInfo;
use OpenDocs\LinkInfo;
use OpenDocs\MarkdownRenderer\MarkdownRenderer;
use OpenDocs\PrevNextLinks;

function getLearningContentLinks(): ContentLinks
{
    // 'description' => "Basic resources why this not here?",
    $links = [
        ContentLink::level1(null, "Best practices"),
        ContentLink::level2('/best_practice_exceptions', 'Exceptions'),
        ContentLink::level2('/best_practice_interfaces_for_external_apis', "Interfaces for external apis"),
        ContentLink::level1(null, "Good docs"),
        ContentLink::level2('/java_exception_antipatterns', "Java exception anti-patterns"),
    ];
//   'path' => 'https://www.kalzumeus.com/2010/06/17/falsehoods-programmers-believe-about-names/',
//   'description' => "Falsehoods Programmers Believe About Names",

//   'path' => 'https://journal.stuffwithstuff.com/2015/02/01/what-color-is-your-function/',
//  'description' => "What Color is Your Function?",

    return new \OpenDocs\ContentLinks($links);
}




$fn = function (
    LearningSection $section,
    MarkdownRenderer $markdownRenderer
) {
    $fullPath = __DIR__ . "/../../../src/Learning/docs/archive_java_exception_antipatterns.md";
    $markdown = file_get_contents($fullPath);
    $html = $markdownRenderer->render($markdown);

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