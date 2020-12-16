<?php

declare(strict_types = 1);

/**
 * This is a set of functions that map exceptions that are otherwise uncaught into
 * acceptable responses that will be seen by the public
 */

use OpenDocs\Breadcrumbs;
use OpenDocs\Page;
use Psr\Http\Message\ResponseInterface;

function debuggingCaughtExceptionExceptionMapperApp(
    \PhpOpenDocs\Exception\DebuggingCaughtException $pdoe,
    ResponseInterface $response
) {
    $text = getTextForException($pdoe);
    \error_log($text);
    $page = Page::errorPage(nl2br($text));
    $html = createPageHtml('/blah', $page, new Breadcrumbs);
    $html .= "\n<!-- This is caught in the exception mapper -->";

    return new \SlimAuryn\Response\HtmlResponse($html, [], 512);
}

function parseErrorMapperForApp(\ParseError $parseError, ResponseInterface $response)
{
    $string = sprintf(
        "Parse error: %s\nFile %s\nLine %d",
        $parseError->getMessage(),
        $parseError->getFile(),
        $parseError->getLine()
    );

    $text = getTextForException($parseError);

    $text = $string . "\n\n\n\n" . $text;

    $page = Page::errorPage(nl2br($text));
    $html = createPageHtml(null, $page, new Breadcrumbs);

    return new \SlimAuryn\Response\HtmlResponse($html, [], 500);
}
