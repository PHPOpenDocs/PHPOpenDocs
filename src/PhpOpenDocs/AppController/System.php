<?php

declare(strict_types = 1);

namespace PHPOpenDocs\AppController;

use OpenDocs\Breadcrumbs;
use PHPOpenDocs\CSPViolation\CSPViolationStorage;
use PHPOpenDocs\Data\ContentPolicyViolationReport;
use SlimAuryn\Response\HtmlResponse;
use SlimAuryn\Response\JsonNoCacheResponse;
use PHPOpenDocs\SystemSection;

class System
{
    public function indexPage(SystemSection $section): HtmlResponse
    {

        $html  = <<< HTML

<h3>System stuff</h3>

<a href="/system/csp_reports">CSP violations report</a><br/>
<a href="/system/csp_test">CSP test page</a><br/>

<a href="/system/htmltest">HTML test page</a><br/>
<a href=""></a><br/>

HTML;

        $page = \OpenDocs\Page::createFromHtml(
            'System',
            $html,
            $section
        );
        $html = createPageHtml(
            $page
        );

        return new HtmlResponse($html);
    }

    public function getReports(SystemSection $section, CSPViolationStorage $csppvStorage) : HtmlResponse
    {
        $reports = $csppvStorage->getReports();

        $html = formatCSPViolationReportsToHtml($reports);

        $page = \OpenDocs\Page::createFromHtml(
            'System',
            $html,
            $section
        );
        $html = createPageHtml(
            $page
        );

        return new HtmlResponse($html);
    }
}
