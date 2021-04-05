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
    $page = createErrorPage(nl2br($text));
    $html = createPageHtml('/blah', $page);
    $html .= "\n<!-- This is caught in the exception mapper -->";

    return new \SlimAuryn\Response\HtmlResponse($html, [], 512);
}

function parseErrorMapperForApp(\ParseError $parseError, ResponseInterface $response)
{
    $string = sprintf(
        "Parse error at %s:%d\n\n%s",
        normaliseFilePath($parseError->getFile()),
        $parseError->getLine(),
        $parseError->getMessage(),
    );

    $text = getStacktraceForException($parseError);

    $text = $string . "\n\n" . $text;

    $page = createErrorPage(nl2br($text));
    $html = createPageHtml(null, $page);

    return new \SlimAuryn\Response\HtmlNoCacheResponse($html, [], 500);
}

function renderAurynInjectionException(
    \Auryn\InjectionException $injectionException,
    ResponseInterface $response
) {

    $text = 'Error creating dependency:<br/>';

    foreach ($injectionException->dependencyChain as $dependency) {
        $text .= "&nbsp;&nbsp;" . $dependency . "<br/>";
    }

    $text .= "<br/>";
    $text .= $injectionException->getMessage();
    $text .= "<br/>";
    $text .= getStacktraceForException($injectionException);

    $page = createErrorPage(nl2br($text));
    $html = createPageHtml(null, $page);

    return new \SlimAuryn\Response\HtmlNoCacheResponse($html, [], 500);

}

function renderMarkdownRendererException(
    \OpenDocs\MarkdownRenderer\MarkdownRendererException $markdownRendererException,
    ResponseInterface $response
) {
    $string = sprintf(
        "MarkdownRendererException at %s:%d\n\n%s",
        normaliseFilePath($markdownRendererException->getFile()),
        $markdownRendererException->getLine(),
        $markdownRendererException->getMessage(),
    );

    $page = createErrorPage(nl2br($string));
    $html = createPageHtml(null, $page);

    return new \SlimAuryn\Response\HtmlNoCacheResponse($html, [], 500);
}

function renderUrlFetcherException(\OpenDocs\UrlFetcher\UrlFetcherException $urlFetcherException)
{
    $string = sprintf(
        "UrlFetcherException failed to fetch uri %s status code %d",
        $urlFetcherException->getUri(),
        $urlFetcherException->getStatusCode()
    );

    $page = createErrorPage(nl2br($string));
    $html = createPageHtml(null, $page);

    return new \SlimAuryn\Response\HtmlNoCacheResponse($html, [], 500);

}