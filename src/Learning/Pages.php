<?php

declare(strict_types = 1);

namespace Learning;

use OpenDocs\Breadcrumb;
use OpenDocs\Breadcrumbs;

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
        "best_practice_exceptions"
    );

    $bestPractices[] = new BestPractice(
        "Interfaces for external apis",
        "People make several common mistakes when using external apis.",
        "best_practice_interfaces_for_external_apis"
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

function generateBestPracticesHtml(): string
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


}
