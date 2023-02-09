<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../../src/web_bootstrap.php";

use Learning\LearningSection;
use OpenDocs\Page;
use function Learning\getLearningContentLinks;
use function Learning\createLearningDefaultCopyrightInfo;

$fn = function (
    LearningSection $section,
    \OpenDocs\BreadcrumbsFactory $breadcrumbsFactory
) : Page {

    $html  = <<< HTML
<h1>Debugging</h1>

<h2>Xdebug</h2>

<h2>GDB</h2>

<h2>Valgrind</h2>

<h2>Wireshark packet analyzer</h2>

<h2>strace</h2>

HTML;
    $contentLinks = getLearningContentLinks();

    $page = Page::createFromHtmlEx2(
        'Debugging',
        $html,
        createPHPOpenDocsEditInfo('Edit page', __FILE__, null),
        $breadcrumbsFactory->createFromArray([]),
        createLearningDefaultCopyrightInfo(),
        createLinkInfo('/', $contentLinks),
        $section
    );

    return $page;
};

showResponse($fn);
