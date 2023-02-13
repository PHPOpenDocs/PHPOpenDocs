<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../../src/web_bootstrap.php";

use Learning\LearningSection;
use OpenDocs\Page;
use OpenDocs\GlobalPageInfo;
use function Learning\getLearningContentLinks;
use function Learning\createLearningDefaultCopyrightInfo;


use function Learning\createGlobalPageInfoForLearning;

function getHtml(LearningSection $section)
{
    $html  = <<< HTML
<h1>Debugging</h1>

<h2>Xdebug</h2>

<h2>GDB</h2>

<h2>Valgrind</h2>

<h2>Wireshark packet analyzer</h2>

<h2>strace</h2>

HTML;
    return $html;
}

$fn = function (LearningSection $section): Page
{
    createGlobalPageInfoForLearning(
        title: 'Learning'
    );
    GlobalPageInfo::setContentHtml(getHtml($section));

    return \OpenDocs\Page::createFromHtmlGlobalPageInfo();
};

showResponse($fn);
