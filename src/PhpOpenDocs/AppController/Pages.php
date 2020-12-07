<?php

declare(strict_types = 1);

namespace PhpOpenDocs\AppController;

use OpenDocs\ContentLinks;
use OpenDocs\Link;
use OpenDocs\PrevNextLinks;
use SlimAuryn\Response\HtmlResponse;
use PhpOpenDocs\ExamplePage;
use PhpOpenDocs\MarkdownPage;
use OpenDocs\Breadcrumb;
use OpenDocs\Breadcrumbs;

class Pages
{
    public function index()
    {
        $html = file_get_contents(__DIR__ . "/test_page.html");

        $page = new ExamplePage();

        $breadcrumbs = new Breadcrumbs(...[
            new Breadcrumb("index.php", "PHP Manual"),
            new Breadcrumb("funcref.php", "Function Reference"),
            new Breadcrumb("refs.basic.vartype.php", "Variable and Type Related Extensions"),
            new Breadcrumb("book.funchand.php", "Function Handling"),
            new Breadcrumb("ref.funchand.php", "Function handling Functions")
        ]);

        $prevNextLinks = new PrevNextLinks(
            new Link("function.func-get-arg.php", "prev link"),
            new Link("function.func-num-args.php", "next link"),
        );

        $contentLinksData = [
            'children' => [
                [
                    'path' => "ref.funchand.php",
                    'description' => "Function handling Functions",
                    'children' => [
                        [
                            'path' => "function.call-user-func-array.php",
                            'description' => "call_​user_​func_​array"
                        ],
                        [
                            'path' => "function.call-user-func.php",
                            'description' => "call_​user_​func",
                        ],
                        [
                            'path' => "function.forward-static-call-array.php",
                            'description' => "forward_​static_​call_​array",
                        ],
                        [
                            'path' => "function.forward-static-call.php",
                            'description' => "forward_​static_​call",
                        ]
                    ],
                ],
                [
                    'description' => 'Deprecated',
                    'children' => [[
                        'path' => "function.create-function.php",
                        'description' => 'create_​function',
                    ]],
                ]
            ]
        ];
        $contentLinks = ContentLinks::createFromArray($contentLinksData);

        $params = [
            ':raw_top_header' =>  createPageHeaderHtml(),
            ':raw_breadcrumbs' => createBreadcrumbHtml($breadcrumbs),
            ':raw_prev_next' => createPrevNextHtml($prevNextLinks),
            ':raw_content' => $page->getPageContent(),
            ':raw_nav_content' => createContentLinksHtml($contentLinks),
            ':raw_footer' => $page->getFooter(),
        ];

        $html = esprintf($html, $params);

        return new HtmlResponse($html);
    }

    public function about()
    {
        $html = file_get_contents(__DIR__ . "/test_page.html");
        $page = new MarkdownPage(__DIR__ . "/../../../docs/php_opendocs_about.md");

        $params = [
            ':raw_top_header' =>  $page->getRawTopHeader(),
            ':raw_breadcrumbs' => "yo breadcrumbss", //$page->getBreadCrumbRaw(),
            ':raw_prev_next' => $page->getPrevNextLinks(),
            ':raw_content' => $page->getPageContent(),
            ':raw_nav_content' => $page->getNavContent(),
            ':raw_footer' => $page->getFooter(),
        ];

        $html = esprintf($html, $params);

        return new HtmlResponse($html);
    }
}
