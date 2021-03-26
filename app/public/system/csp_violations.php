<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use OpenDocs\Breadcrumbs;
use PhpOpenDocs\CSPViolation\CSPViolationStorage;
use SlimAuryn\Response\HtmlResponse;

$fn = function (CSPViolationStorage $cspvStorage) : HtmlResponse
{
    $reports = $cspvStorage->getReports();

    $html = formatCSPViolationReportsToHtml($reports);

    $page = \OpenDocs\Page::createFromHtmlEx(
        'System',
        $html,
        createPHPOpenDocsEditInfo('Edit page', __FILE__, null),
        Breadcrumbs::fromArray([
            '/system' => 'System',
//            '/system/csp_violations' => 'CSP violations'
            'CSP violations'
        ])
    );
    $html = createPageHtml(
        null,
        $page
    );

    return new HtmlResponse($html);
};

showResponse($fn);
