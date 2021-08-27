<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use Internals\InternalsSection;

use OpenDocs\BreadcrumbsFactory;
use OpenDocs\Page;
use function Internals\getInternalsContentLinks;
use function Internals\createInternalsDefaultCopyrightInfo;

$fn = function (
    InternalsSection $section,
    BreadcrumbsFactory $breadcrumbsFactory
) : Page {

    $html  = <<< HTML
<h1>PHP internals info</h1>

<p>
Info about PHP core development.
</p>

<h2>Etiquette and RFCs</h2>
<ul>
  <li>
    <a href='{$section->getPrefix()}/mailing_list'>Mailing list</a> - Mailing list etiquette.
  </li>

  <li>
    <a href='{$section->getPrefix()}/rfc_attitudes'>RFC attitudes</a> - understand the attitude the PHP internal participants take when evaluating RFCs.
  </li>
  
  <li>
    <a href='{$section->getPrefix()}/rfc_etiquette'>RFC Etiquette</a> - notes on etiquette surrounding RFCs.
  </li>
</ul>



<h2>Miscellaneous info</h2>

<p>php run-tests.php -j$(nproc)</p>


HTML;

    $contentLinks = getInternalsContentLinks();

    $page = Page::createFromHtmlEx2(
        'Internals',
        $html,
        createPHPOpenDocsEditInfo('Edit page', __FILE__, null),
        $breadcrumbsFactory->createFromArray([]),
        createInternalsDefaultCopyrightInfo(),
        createLinkInfo('/', $contentLinks),
        $section
    );

    return $page;
};

showLearningResponse($fn);
