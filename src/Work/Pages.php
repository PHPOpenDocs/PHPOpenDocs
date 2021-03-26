<?php

declare(strict_types = 1);

namespace Work;

use OpenDocs\Breadcrumb;
use OpenDocs\Breadcrumbs;
use OpenDocs\ContentLinkLevel1;
use OpenDocs\ContentLinkLevel2;
use OpenDocs\ContentLinks;
use OpenDocs\CopyrightInfo;
use OpenDocs\GetRoute;
use OpenDocs\Page;
use OpenDocs\PrevNextLinks;
use OpenDocs\Section;

class Pages
{
    public function getIndexPage(Section $section): Page
    {
        $words = <<< HTML

<h1>Work</h1>

<p>
This page helps distribute the workload of PHP, by showing people work that needs doing.
</p>


<h2>Comments</h2>
<div class="widget_php_bugs_comments">

</div>

HTML;

        return new Page(
            'PHP Work',
            createEditInfo('Edit page', __FILE__, __LINE__ - 33),
            $this->getContentLinks(),
            new PrevNextLinks(null, null),
            $words,
            new CopyrightInfo('Danack', 'https://github.com/Danack/RfcCodex/blob/master/LICENSE'),
            $breadcrumbs = new Breadcrumbs()
        );
    }

    public function getContentLinks(): ContentLinks
    {
        $nouns = new ContentLinkLevel1(
            "/nouns",
            "Nouns",
            null
        );

        $verbs = new ContentLinkLevel1(
            "/verbs",
            "Verbs",
            null
        );

        return new ContentLinks([$nouns, $verbs]);
    }
}
