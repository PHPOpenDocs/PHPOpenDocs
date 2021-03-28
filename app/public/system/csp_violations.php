<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use OpenDocs\Breadcrumbs;
use PhpOpenDocs\CSPViolation\CSPViolationStorage;
use SlimAuryn\Response\HtmlResponse;

$fn = function (CSPViolationStorage $cspvStorage) : HtmlResponse
{
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

    $page = \OpenDocs\Page::createFromHtmlEx(
        'System',
        $html,
        createPHPOpenDocsEditInfo('Edit page', __FILE__, null),
        Breadcrumbs::fromArray([
            '/system' => 'System',
            '/system/csp_violations' => 'CSP violations'
        ])
    );
    $html = createPageHtml(
        null,
        $page
    );

    return new HtmlResponse($html);
};

showResponse($fn);
