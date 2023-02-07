<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use PhpOpenDocs\CSPViolation\CSPViolationStorage;
use OpenDocs\Page;

$fn = function (
    CSPViolationStorage $cspvStorage,
//    SystemSection $systemSection
//    \OpenDocs\BreadcrumbsFactory $breadcrumbsFactory
): Page {

    $html = <<< HTML
<h1>CSP violations report</h1>

<p>This site has a quite locked down Content Security Policy. If there are every some entries below, other than for the test page, they...should be fixed.</p>

HTML;

    try {
        $reports = $cspvStorage->getReports();
        $html .= formatCSPViolationReportsToHtml($reports);
    }
    catch (\RedisException $redisException) {
        $html .= "<p>Redis is having a problem: " . $redisException->getMessage() . "</p>";
    }

//    $page = \OpenDocs\Page::createFromHtmlEx(
//        'System',
//        $html,
//        createPhpOpenDocsEditInfo('Edit page', __FILE__, null),
//        $breadcrumbsFactory->createFromArray(['/csp_violations' => 'CSP violations'])
//    );


    createGlobalPageInfoForSystem(
        title: 'CSP Violations',
        html: $html
    );

    return \OpenDocs\Page::createFromHtmlGlobalPageInfo();

//    return $page;
};

showResponse($fn);
