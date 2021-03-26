<?php

declare(strict_types = 1);

namespace PhpOpenDocs\AppController;

use PhpOpenDocs\Data\ContentPolicyViolationReport;
use SlimAuryn\Response\JsonNoCacheResponse;
use SlimAuryn\Response\HtmlResponse;
use PhpOpenDocs\CSPViolation\CSPViolationReporter;
use PhpOpenDocs\CSPViolation\CSPViolationStorage;
use SlimAuryn\Response\TextResponse;
use PhpOpenDocs\JsonInput\JsonInput;

class ContentSecurityPolicy
{
    public function postReport(
        CSPViolationStorage $violationReporter,
        JsonInput $jsonInput
    ) {
        $payload = $jsonInput->getData();

        $cspReport = ContentPolicyViolationReport::fromCSPPayload($payload);
        $violationReporter->report($cspReport);

        return new TextResponse("CSP report accepted.\n", [], 201);
    }

    public function clearReports(CSPViolationStorage $csppvReporter) : JsonNoCacheResponse
    {
        $csppvReporter->clearReports();
        return new JsonNoCacheResponse(['ok']);
    }

    public function getReports(CSPViolationStorage $csppvStorage) : JsonNoCacheResponse
    {
        $reports = $csppvStorage->getReports();

        $data = [];
        foreach ($reports as $report) {
            $data[] = $report->toArray();
        }

        return new JsonNoCacheResponse($data);
    }

    public function getTestPage() : HtmlResponse
    {
        $html = <<< HTML
<html>
<body>
  Hello, I am a test page, that tries to load some naughty javascript, which should trigger a CSP report.
</body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</html>
HTML;

        return new HtmlResponse($html);
    }
}
