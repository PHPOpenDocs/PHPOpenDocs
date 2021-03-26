<?php

declare(strict_types = 1);

namespace Learning;

use OpenDocs\Breadcrumb;
use OpenDocs\Breadcrumbs;
use OpenDocs\ContentLinks;
use OpenDocs\CopyrightInfo;
use OpenDocs\MarkdownRenderer\MarkdownRenderer;
use OpenDocs\Page;
use OpenDocs\PrevNextLinks;
use OpenDocs\Section;

/**
 * @return BestPractice[]
 */
function getBestPractices()
{
    $bestPractices = [];
    $bestPractices[] = new BestPractice(
        "Exceptions",
        "How to use exceptions successfully, and avoid bad patterns.",
        "best_practice_exceptions.md"
    );

    $bestPractices[] = new BestPractice(
        "Interfaces for external apis",
        "People make several common mistakes when using external apis.",
        "best_practice_interfaces_for_external_apis.md"
    );

    return $bestPractices;
}

/**
 * @return \Learning\GoodDoc[]
 */
function getGoodDocs(Section $section)
{
    $goodDocs = [];
    $goodDocs[] = new GoodDoc(
        "Falsehoods Programmers Believe About Names",
        "A list of assumptions your systems probably make about names. All of these assumptions are wrong. Try to make less of them next time you write a system which touches names.",
        "https://www.kalzumeus.com/2010/06/17/falsehoods-programmers-believe-about-names/"
    );

    $goodDocs[] = new GoodDoc(
        "What Color is Your Function?",
        "A list of assumptions your systems probably make about names. All of these assumptions are wrong. Try to make less of them next time you write a system which touches names.",
        "https://journal.stuffwithstuff.com/2015/02/01/what-color-is-your-function/"
    );

    $goodDocs[] = new GoodDoc(
        "Java exception anti-patterns",
        "An article from 2006 about common anti-patterns regarding exceptions in Java.",
        $section->getPrefix() . "/java_exception_antipatterns"
    );


//    https://www.mjt.me.uk/posts/falsehoods-programmers-believe-about-addresses/ ?

    return $goodDocs;
}

function generateGoodDocsHtml(Section $section): string
{
    $goodDocs = getGoodDocs($section);
    $lines = [];
    $template = "<li><a href=':attr_link'>:html_name</a> - :html_description</li>";

    foreach ($goodDocs as $bp) {
        $params = [
            ':attr_link' => $bp->getLink(),
            ':html_name' => $bp->getName(),
            ':html_description' => $bp->getDescription()
        ];
        $lines[] = esprintf($template, $params);
    }

    return implode("\n", $lines);
}

function generateBestPracticesHtml()
{
    $bps = getBestPractices();
    $lines = [];
    $template = "<li><a href=':attr_link'>:html_name</a> - :html_description</li>";

    foreach ($bps as $bp) {
        $params = [
            ':attr_link' => $bp->getFile(),
            ':html_name' => $bp->getName(),
            ':html_description' => $bp->getDescription()
        ];
        $lines[] = esprintf($template, $params);
    }

    return implode("\n", $lines);
}

class Pages
{

    public function getPhpForPeopleWhoCanCode(
        Section $section,
        MarkdownRenderer $markdownRenderer
    ) {
        $fullPath = __DIR__ . "/docs/php_for_people_who_know_how_to_code.md";
        $markdown = file_get_contents($fullPath);
        $contents = $markdownRenderer->render($markdown);

        return new Page(
            'PHP for people who know how to code.' ,
            createDefaultEditInfo(),
            $this->getContentLinks(),
            new PrevNextLinks(null, null),
            $contents,
            new CopyrightInfo(
                'Danack',
                'https://github.com/Danack/RfcCodex/blob/master/LICENSE'
            ),
            $breadcrumbs = new Breadcrumbs(new Breadcrumb(
                '/php_for_people_who_know_how_to_code', 'jane')
            )
        );
    }

    public function getJavaAntipatterns(
        Section $section,
        MarkdownRenderer $markdownRenderer
    ) {

        $fullPath = __DIR__ . "/docs/archive_java_exception_antipatterns.md";
        $markdown = file_get_contents($fullPath);
        $contents = $markdownRenderer->render($markdown);

        return new Page(
            'Java Exception Antipatterns' ,
            createDefaultEditInfo(),
            $this->getContentLinks(),
            new PrevNextLinks(null, null),
            $contents,
            new CopyrightInfo(
                'Tim McCune',
                'https://github.com/Danack/RfcCodex/blob/master/LICENSE'
            ),
            $breadcrumbs = new Breadcrumbs(new Breadcrumb(
                '/php_for_people_who_know_how_to_code', 'Java Exception Antipatterns')
            )
        );
    }




    public function getIndexPage(Section $section): Page
    {
        $words = <<< HTML

<h1>Learning PHP</h1>

<p>
So you want to learn some PHP ?
</p>

<h2>Info for people who already know how to code</h2>

<a href=":attr_link_1">PHP for people who know how to code</a>


<h2>Library recommendations</h2>

<h2>Best practices</h2>
<ul>
:raw_best_practices
</ul>

<h2>Good docs</h2>
<ul>
:raw_good_docs
</ul>

HTML;

        $params = [
            ":attr_link_1" => $section->getPrefix() . '/php_for_people_who_know_how_to_code',
            ':raw_best_practices' => generateBestPracticesHtml(),
            ':raw_good_docs' => generateGoodDocsHtml($section)
        ];

        $content = esprintf($words, $params);


        return new Page(
            'Learning PHP',
            createEditInfo('Edit page', __FILE__, __LINE__ - 33),
            $this->getContentLinks(),
            new PrevNextLinks(null, null),
            $content,
            new CopyrightInfo('Danack', 'https://github.com/Danack/RfcCodex/blob/master/LICENSE'),
            $breadcrumbs = new Breadcrumbs()
        );
    }

    public function getContentLinks(): ContentLinks
    {
//        $nouns = new ContentLinkLevel1(
//            "/nouns",
//            "Nouns",
//            null
//        );

//        $verbs = new ContentLinkLevel1(
//            "/verbs",
//            "Verbs",
//            null
//        );

        return new ContentLinks([]);
    }
}
