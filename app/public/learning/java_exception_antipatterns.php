<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use OpenDocs\Breadcrumb;
use OpenDocs\Breadcrumbs;
use OpenDocs\ContentLinks;
use OpenDocs\CopyrightInfo;
use OpenDocs\MarkdownRenderer\MarkdownRenderer;
use OpenDocs\Page;
use OpenDocs\PrevNextLinks;
use OpenDocs\Section;
use Learning\LearningSection;
use OpenDocs\LinkInfo;
use OpenDocs\ContentLink;

function getLearningContentLinks(): ContentLinks
{
    $links = [
        ContentLink::level1(null, "Best practices"),
    ];


    $data = [
        'description' => "Basic resources why this not here?",
        'children' => [
            [
                'description' => "Best practices",
                'children' => [
                    [
                        'path' => '/best_practice_exceptions',
                        'description' => 'Exceptions',
                    ],
                    [
                        'path' => '/best_practice_interfaces_for_external_apis',
                        'description' => "Interfaces for external apis",
                    ]
                ]
            ],

            //    "Library recommendations"

            [
                'description' => "Good docs",
                'children' => [
                    [
                        'path' => '/java_exception_antipatterns',
                        'description' => "Java exception anti-patterns"
                    ],
//                    [
//                        'path' => 'https://www.kalzumeus.com/2010/06/17/falsehoods-programmers-believe-about-names/',
//                        'description' => "Falsehoods Programmers Believe About Names",
//                    ],
//                    [
//                        'path' => 'https://journal.stuffwithstuff.com/2015/02/01/what-color-is-your-function/',
//                            'description' => "What Color is Your Function?",
//                    ]
                ]
            ]
        ]
    ];

    $contentLinksData = ['children' => $data];

    $contentLinks = \OpenDocs\ContentLinks::createFromArray($data);

    return $contentLinks;
}

function createPrevNextLinksFromContentLinks(
    \OpenDocs\ContentLinks $contentLinks,
    string $currentPosition
) {
    $flatLinks = [];
    foreach ($contentLinks->getChildren() as $level1) {
        $flatLinks[] = [
            'path' => $level1->getPath(),
            'description' => $level1->getDescription()
        ];

        if ($level1->getChildren() === null) {
            continue;
        }
        foreach ($level1->getChildren() as $level2) {
            $flatLinks[] = [
                'path' => $level2->getPath(),
                'description' => $level2->getDescription()
            ];

            if ($level2->getChildren() === null) {
                continue;
            }

            foreach ($level2->getChildren() as $level3) {
                $flatLinks[] = [
                    'path' => $level3->getPath(),
                    'description' => $level3->getDescription()
                ];
            }
        }
    }

    $currentLink = null;
    $previousLink = null;
    $nextLink = null;

    foreach ($flatLinks as $flatLink) {
        if ($nextLink === null && $previousLink !== null) {
            $nextLink = new \OpenDocs\Link(
                $flatLink['path'],
                $flatLink['description']
            );
        }

        if ($flatLink['path'] === $currentPosition) {
            if ($currentLink !== null && $currentLink['path'] !== null) {
                $previousLink = new \OpenDocs\Link(
                    $currentLink['path'],
                    $currentLink['description']
                );
            }
        }

        $currentLink = $flatLink;
    }

    return new PrevNextLinks($previousLink, $nextLink);
}

function createLinkInfo(string $currentPosition): LinkInfo
{
    //    '/php_for_people_who_know_how_to_code' => "PHP for people who know how to code"

    $contentLinks = getLearningContentLinks();

    $prevNext = createPrevNextLinksFromContentLinks($contentLinks, $currentPosition);
    return new \OpenDocs\LinkInfo(
        $prevNext,
        $contentLinks,
    );
}


$fn = function (
    LearningSection $section,
    MarkdownRenderer $markdownRenderer
) {
    $fullPath = __DIR__ . "/../../../src/Learning/docs/archive_java_exception_antipatterns.md";
    $markdown = file_get_contents($fullPath);
    $html = $markdownRenderer->render($markdown);

//    $page = new Page(
//        'Java Exception Antipatterns' ,
//        createDefaultEditInfo(),
//        new ContentLinks([]),
//        new PrevNextLinks(null, null),
//        $contents,
//        new CopyrightInfo(
//            'Tim McCune',
//            'https://github.com/Danack/RfcCodex/blob/master/LICENSE'
//        ),
//        $breadcrumbs = new Breadcrumbs(new Breadcrumb(
//            '/php_for_people_who_know_how_to_code', 'Java Exception Antipatterns')
//        )
//    );

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
        createLinkInfo('/java_exception_antipatterns')
    );


    return convertPageToHtmlResponse($section, $page);
};

showResponse($fn);