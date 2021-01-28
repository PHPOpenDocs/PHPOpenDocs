<?php

declare(strict_types = 1);

namespace PhpOpenDocs\AppController;

use OpenDocs\Breadcrumbs;
use OpenDocs\ContentLinks;
use OpenDocs\PrevNextLinks;
use OpenDocs\URL;
use OpenDocs\CopyrightInfo;
use PhpOpenDocs\MarkdownPage;
use SlimAuryn\Response\HtmlResponse;
use SlimAuryn\Response\StubResponse;

class ExternalPages
{


    public function tools(): StubResponse
    {
        $page = new MarkdownPage(__DIR__ . "/../../../external/php-static-analysis-tools/README.md");

        $page = new \OpenDocs\Page(
            $title = 'PHP OpenDocs',
            $editUrl = new URL('www.example.com'),
            ContentLinks::createEmpty(),
            new PrevNextLinks(null, null),
            $contentHtml = $page->getPageContent(),
            new CopyrightInfo('Exakat', 'https://github.com/exakat/php-static-analysis-tools/blob/master/LICENSE.md')
        );


//



        $html = createPageHtml(
            null,
            $page,
            $breadcrumbs = new Breadcrumbs()
        );

        return new HtmlResponse($html);
    }
}
