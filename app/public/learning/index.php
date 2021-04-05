<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use Learning\LearningSection;
use OpenDocs\ContentLink;
use OpenDocs\Page;
use function Learning\getLearningContentLinks;
use function Learning\createLearningDefaultCopyrightInfo;

$fn = function (
    LearningSection $section,
    \OpenDocs\BreadcrumbsFactory $breadcrumbsFactory
) : Page {

    $html  = <<< HTML
<h1>Learning PHP</h1>

<p>
So you want to learn some PHP ?
</p>

<h2>Info for people who already know how to code</h2>

<p>
  <a href="{$section->getPrefix()}/php_for_people_who_know_how_to_code">PHP for people who know how to code</a>
</p>

<h2>Library recommendations</h2>

<ul>
  <li>
    <a href='{$section->getPrefix()}/php_static_analysis_tools'>Static analysis tools</a> - A curated list of static analysis tools for PHP.</li>
  </li>
</ul>

<h2>Best practices</h2>
<ul>
  <li>
    <a href='{$section->getPrefix()}/best_practice_exceptions'>Exceptions</a> - How to use exceptions successfully, and avoid bad patterns.
  </li>
  <li>
    <a href='{$section->getPrefix()}/best_practice_interfaces_for_external_apis'>Interfaces for external apis</a> - People make several common mistakes when using external apis.
  </li>
</ul>

<h2>Good docs</h2>
<ul>
  <li>
    <a href="{$section->getPrefix()}/java_exception_antipatterns">Java exception anti-patterns</a> - An article from 2006 about common anti-patterns regarding exceptions in Java.
  </li>
  
  <li>
    <a href="{$section->getPrefix()}/unit_testing_tips">Unit testing tips</a>
  </li>
</ul>

<h2>External links</h2>

<ul>
 <li>
    <a href="https://www.kalzumeus.com/2010/06/17/falsehoods-programmers-believe-about-names/">Falsehoods Programmers Believe About Names</a> - A list of assumptions your systems probably make about names. All of these assumptions are wrong. Try to make less of them next time you write a system which touches names.
  </li>
  
  <li>
    <a href="https://journal.stuffwithstuff.com/2015/02/01/what-color-is-your-function/">What Color is Your Function?</a> - A list of assumptions your systems probably make about names. All of these assumptions are wrong. Try to make less of them next time you write a system which touches names.
  </li>
</ul>
HTML;
    $contentLinks = getLearningContentLinks();

    $page = Page::createFromHtmlEx2(
        'Learning',
        $html,
        createPHPOpenDocsEditInfo('Edit page', __FILE__, null),
        $breadcrumbsFactory->createFromArray([]),
        createLearningDefaultCopyrightInfo(),
        createLinkInfo('/', $contentLinks),
        $section
    );

    return $page;
};

showLearningResponse($fn);
