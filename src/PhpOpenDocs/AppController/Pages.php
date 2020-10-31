<?php

declare(strict_types = 1);

namespace PhpOpenDocs\AppController;

use SlimAuryn\Response\HtmlResponse;
use PhpOpenDocs\ExamplePage;

class Pages
{
    public function index()
    {
        $html = file_get_contents(__DIR__ . "/test_page.html");

        $page = new ExamplePage();

        $params = [
            ':raw_top_header' =>  $page->getRawTopHeader(),
            ':raw_bread_crumbs' => $page->getBreadCrumbRaw(),
            ':raw_prev_next_links' => $page->getPrevNextLinks(),
            ':raw_content' => $page->getPageContent(),
            ':raw_nav_content' => $page->getNavContent()
        ];

        $html = esprintf($html, $params);

        return new HtmlResponse($html);
    }
}
