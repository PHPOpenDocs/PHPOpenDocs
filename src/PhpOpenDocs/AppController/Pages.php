<?php

declare(strict_types = 1);

namespace PhpOpenDocs\AppController;

use OpenDocs\ContentLinks;
use OpenDocs\CopyrightInfo;
use OpenDocs\Link;
use OpenDocs\PrevNextLinks;
use OpenDocs\URL;
use SlimAuryn\Response\HtmlResponse;
use PhpOpenDocs\ExamplePage;
use PhpOpenDocs\MarkdownPage;
use OpenDocs\Breadcrumb;
use OpenDocs\Breadcrumbs;
use OpenDocs\SectionList;
use SlimAuryn\Response\StubResponse;
use OpenDocs\EditInfo;

class Pages
{
    public function get404Page(): StubResponse
    {
        $page = new \OpenDocs\Page(
            $title = 'PHP OpenDocs',
            createDefaultEditInfo(),
            ContentLinks::createEmpty(),
            new PrevNextLinks(null, null),
            $contentHtml = "404, you know the score.",
            createDefaultCopyrightInfo(),
            new Breadcrumbs()
        );

        $html = createPageHtml(
            null,
            $page
        );

        return new HtmlResponse($html);
    }



    public function index(SectionList $sectionList): StubResponse
    {
        $html  = <<< HTML

<h3>Hello</h3>
<p>
Not much here yet.
Maybe check out the proposed sections...
</p>
HTML;

        $html .= getSectionHtml($sectionList);


        $html .= "<p>Oh, and there's the <a href='/system'>system page</a></p>";

        $page = \OpenDocs\Page::createFromHtml(
            'Index',
            $html
        );
        $html = createPageHtml(
            null,
            $page
        );

        return new HtmlResponse($html);
    }

    public function htmlTest(): StubResponse
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
            createDefaultEditInfo(),
            $contentLinks,
            $prevNextLinks,
            $contentHtml = $examplePage->getPageContent(),
            createDefaultCopyrightInfo(),
            new Breadcrumbs()
        );

        $html = createPageHtml(
            null,
            $page
        );
        return new HtmlResponse($html);
    }



    public function about(): StubResponse
    {
        $page = new MarkdownPage(__DIR__ . "/../../../docs/php_opendocs_about.md");

        $page = new \OpenDocs\Page(
            $title = 'PHP OpenDocs',
            createPHPOpenDocsEditInfo('Edit page', realpath(__DIR__ . "/../../../docs/php_opendocs_about.md"), null),
            ContentLinks::createEmpty(),
            new PrevNextLinks(null, null),
            $contentHtml = $page->getPageContent(),
            createDefaultCopyrightInfo(),
            new Breadcrumbs()
        );

        $html = createPageHtml(
            null,
            $page
        );

        return new HtmlResponse($html);
    }

    public function privacyPolicy()
    {
    }


    public function sections(SectionList $sectionList): StubResponse
    {
        $html = getSectionHtml($sectionList);

        $page = new \OpenDocs\Page(
            $title = 'PHP OpenDocs',
            createDefaultEditInfo(),
            ContentLinks::createEmpty(),
            new PrevNextLinks(null, null),
            $contentHtml = $html,
            createDefaultCopyrightInfo(),
            new Breadcrumbs()
        );

        $html = createPageHtml(
            null,
            $page
        );

        return new HtmlResponse($html);
    }
}
