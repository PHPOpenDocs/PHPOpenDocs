<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use OpenDocs\Breadcrumbs;

$html  = <<< HTML

<h3>System stuff</h3>

<a href="/system/csp_violations">CSP violations report</a><br/>
<a href="/system/csp_test">CSP test page</a><br/>
<a href="/system/htmltest">HTML test page</a><br/>
<br/>

<h3>Test stuff</h3>
<a href="/system/exception_test">Exception test page</a><br/>
<br/>

<h3>Misc</h3>
<a href="/system/brain_dump">Brain dump</a><br/>

HTML;

$page = \OpenDocs\Page::createFromHtmlEx(
    'System',
    $html,
    createPhpOpenDocsEditInfo('Edit page', __FILE__, null),
    Breadcrumbs::fromArray(['/system' => 'System'])
);

showPage($page);



