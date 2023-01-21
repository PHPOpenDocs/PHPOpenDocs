<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use PhpOpenDocs\CSPViolation\CSPViolationStorage;
use SlimAuryn\Response\HtmlResponse;
use OpenDocs\Breadcrumbs;

$exceptionTypes = [
    \OpenDocs\UrlFetcher\UrlFetcherException::class => function () {
        throw \OpenDocs\UrlFetcher\UrlFetcherException::notOk(404, 'http://example.com');
    },
];


function triggerException(string $type)
{
    global $exceptionTypes;

    if (array_key_exists($type, $exceptionTypes) !== true) {
        return "Unknown exception type: " . $type;
    }

    $fn = $exceptionTypes[$type];
    $fn();

    return "This should never be reached...";
}

$fn = function (\VarMap\VarMap $varMap): HtmlResponse
{
    global $exceptionTypes;

    $html = '<h1>Exception tests</h1>';

    $exceptionType = $varMap->getWithDefault('exception_type', null);

    if ($exceptionType !== null) {
        $result = triggerException($exceptionType);
        $html .= "<h2>Problem testing exception</h2>" . $result;
    }


    $html .= <<< HTML

<h2>blah blahy</h2>

<p>This is a page for testing that exception error handling works correctly.</p>

<p>Exceptions are shown for the pages that may trigger them, so that content editors can figure out why their stuff isn't working. e.g. if a markdown file has been renamed in an external repo, then trying to render that file on this site isn't going to work....</p>

<form method="get">
  <select name="exception_type">
HTML;

    foreach ($exceptionTypes as $exceptionType => $fn) {
        $html .= "<option value='$exceptionType'>$exceptionType</option>";
    }
    
$html .= <<< HTML
  </select>
  <br/>

  <input type="submit" value="Submit">
</form>
HTML;

    



    $page = \OpenDocs\Page::createFromHtmlEx(
        'System',
        $html,
        createPhpOpenDocsEditInfo('Edit page', __FILE__, null),
        Breadcrumbs::fromArray([
            '/system' => 'System',
            '/system/exception_test' => 'Exception test'
        ])
    );
    $html = createPageHtml(
        null,
        $page
    );

    return new HtmlResponse($html);
};

showResponse($fn);