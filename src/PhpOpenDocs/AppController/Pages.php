<?php

declare(strict_types = 1);

namespace PhpOpenDocs\AppController;

use OpenDocs\ContentLinks;
use OpenDocs\Link;
use OpenDocs\PrevNextLinks;
use OpenDocs\URL;
use SlimAuryn\Response\HtmlResponse;
use PhpOpenDocs\ExamplePage;
use PhpOpenDocs\MarkdownPage;
use OpenDocs\Breadcrumb;
use OpenDocs\Breadcrumbs;
use SlimAuryn\Response\StubResponse;
use RfcCodexOpenDocs\RfcCodex;

class Pages
{
    public function index(): StubResponse
    {
        $examplePage = new ExamplePage();

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

        $page = new \OpenDocs\Page(
            $title = 'PHP OpenDocs',
            $editUrl = new URL('www.example.com'),
            $contentLinks,
            $prevNextLinks,
            $contentHtml = $examplePage->getPageContent(),
            $copyrightOwner = 'PHP Open docs'
        );

        $sectionPath = '/';
        $html = createPageHtml(
            $sectionPath,
            $page,
            $breadcrumbs
        );
        return new HtmlResponse($html);
    }

    public function rfc_codex_item($name): StubResponse
    {
        $injector = new \Auryn\Injector();
        $injectionParams = getSectionInjectionParams();
        $injectionParams->addToInjector($injector);

        $rfcCodex = $injector->make(\RfcCodexOpenDocs\RfcCodex::class);

        $page = $rfcCodex->getPage($name);
        $breadcrumbs = new Breadcrumbs();

        $sectionPath = '/rfc_codex';
        $html = createPageHtml(
            $sectionPath,
            $page,
            $breadcrumbs
        );

        return new HtmlResponse($html);
    }

    public function rfc_codex(RfcCodex $rfcCodex): StubResponse
    {
        $injector = new \Auryn\Injector();
        $injectionParams = getSectionInjectionParams();
        $injectionParams->addToInjector($injector);

        $rfcCodex = $injector->make(\RfcCodexOpenDocs\RfcCodex::class);

        $page = $rfcCodex->getPage('blaah');
        $breadcrumbs = new Breadcrumbs();

        $params = [
            ':raw_top_header' =>  createPageHeaderHtml(),
            ':raw_breadcrumbs' => createBreadcrumbHtml($breadcrumbs),
            ':raw_prev_next' => createPrevNextHtml($page->getPrevNextLinks()),
            ':raw_content' => $page->getContentHtml(),
            ':raw_nav_content' => createContentLinksHtml('/rfc_codex', $page->getContentLinks()),
            ':raw_footer' => createFooterHtml($page->getCopyrightOwner(), $page->getEditUrl()),
        ];

        $html = file_get_contents(__DIR__ . "/test_page.html");


        $html = esprintf($html, $params);

        return new HtmlResponse($html);
    }

    public function about(): StubResponse
    {

        $page = new MarkdownPage(__DIR__ . "/../../../docs/php_opendocs_about.md");

        $page = new \OpenDocs\Page(
            $title = 'PHP OpenDocs',
            $editUrl = new URL('www.example.com'),
            ContentLinks::createEmpty(),
            new PrevNextLinks(null, null),
            $contentHtml = $page->getPageContent(),
            $copyrightOwner = 'PHP Open docs'
        );

        $html = createPageHtml(
            "/",
            $page,
            $breadcrumbs = new Breadcrumbs()
        );

        return new HtmlResponse($html);
    }
}
