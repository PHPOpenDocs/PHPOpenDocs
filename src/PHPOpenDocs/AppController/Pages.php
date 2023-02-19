<?php

declare(strict_types = 1);

namespace PHPOpenDocs\AppController;

use OpenDocs\Breadcrumb;
use OpenDocs\Breadcrumbs;
use OpenDocs\ContentLink;
use OpenDocs\PrevNextLinks;
use OpenDocs\SectionList;
use PHPOpenDocs\ExamplePage;
use PHPOpenDocs\MarkdownPage;
use SlimAuryn\Response\HtmlResponse;
use SlimAuryn\Response\StubResponse;

class Pages
{
    public function get404Page(): StubResponse
    {
        $page = new \OpenDocs\Page(
            $title = 'PHP OpenDocs',
            createDefaultEditInfo(),
            [],
            new PrevNextLinks(null, null),
            $contentHtml = "404, you know the score.",
            createDefaultCopyrightInfo(),
            new Breadcrumbs(),
            null
        );

        $html = createPageHtml(
            $page
        );

        return new HtmlResponse($html, [], 404);
    }



    public function index(SectionList $sectionList): StubResponse
    {
        $html  = <<< HTML

<h3>Hello</h3>
<p>
Not much here yet. 
</p>

<p>
Things to do before going live:
</p>
<ul>
    <li>Actually split at least one of the sections off into a separate repo.</li>
    <li>Implement a build system, and a page to show the status of the build system.</li>
    <li>Go through and make sure all of the edit links are working...</li>
    <li>Get someone to review CSS. And then someone to do colours for dark mode.</li>
    <li>Broken link checker.</li>
    <li>Write some instructions on how to create pages, sections or other stuff...</li>
</ul>

<p>Maybe check out the proposed sections...</p>
HTML;

        $html .= getSectionHtml($sectionList);

        $html .= "<p>Oh, and there's the <a href='/system'>system page</a></p>";

        $page = \OpenDocs\Page::createFromHtml(
            'Index',
            $html,
            null
        );
        $html = createPageHtml(
            $page
        );

        return new HtmlResponse($html);
    }

    public function htmlTest(): StubResponse
    {
        $examplePage = new ExamplePage();

        $breadcrumbs = new Breadcrumbs(...[
            new Breadcrumb("/system/htmltest", "PHP Manual"),
            new Breadcrumb("/system/htmltest", "Function Reference"),
            new Breadcrumb("/system/htmltest", "Variable and Type Related Extensions"),
            new Breadcrumb("/system/htmltest", "Function Handling"),
            new Breadcrumb("/system/htmltest", "Function handling Functions")
        ]);


        $prevNextLinks = new PrevNextLinks(
            ContentLink::level1("/system/htmltest", "prev link"),
            ContentLink::level1("/system/htmltest", "next link"),
        );

        $contentLinks = [
            ContentLink::level1(null, "Function handling Functions"),
            ContentLink::level2("/system/htmltest", "call_​user_​func_​array"),
            ContentLink::level2("/system/htmltest", "call_​user_​func"),
            ContentLink::level2("/system/htmltest", "forward_​static_​call_​array"),
            ContentLink::level2("/system/htmltest", "forward_​static_​call"),
            ContentLink::level1(null, 'Deprecated'),
            ContentLink::level2("/system/htmltest", 'create_​function'),
        ];

        $page = new \OpenDocs\Page(
            $title = 'PHP OpenDocs',
            createDefaultEditInfo(),
            $contentLinks,
            $prevNextLinks,
            $contentHtml = $examplePage->getPageContent(),
            createDefaultCopyrightInfo(),
            $breadcrumbs,
            null
        );

        $html = createPageHtml(
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
            [],
            new PrevNextLinks(null, null),
            $contentHtml = $page->getPageContent(),
            createDefaultCopyrightInfo(),
            new Breadcrumbs(),
            null
        );

        $html = createPageHtml(
            $page
        );

        return new HtmlResponse($html);
    }

    public function privacyPolicy(): void
    {
    }


    public function sections(SectionList $sectionList): StubResponse
    {
        $html = getSectionHtml($sectionList);

        $page = new \OpenDocs\Page(
            $title = 'PHP OpenDocs',
            createDefaultEditInfo(),
            [],
            new PrevNextLinks(null, null),
            $contentHtml = $html,
            createDefaultCopyrightInfo(),
            new Breadcrumbs(),
            null
        );

        $html = createPageHtml(
            $page
        );

        return new HtmlResponse($html);
    }
}