<?php

declare(strict_types = 1);

namespace PhpOpenDocs\AppController;

use OpenDocs\Breadcrumbs;
use PhpOpenDocs\CSPViolation\CSPViolationStorage;
use PhpOpenDocs\Data\ContentPolicyViolationReport;
use SlimAuryn\Response\HtmlResponse;
use SlimAuryn\Response\JsonNoCacheResponse;
use PhpOpenDocs\SystemSection;

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
            $section,
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
            $section,
            $page
        );

        return new HtmlResponse($html);
    }
}
