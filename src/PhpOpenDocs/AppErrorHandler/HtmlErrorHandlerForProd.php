<?php

declare(strict_types = 1);

namespace PHPOpenDocs\AppErrorHandler;

use OpenDocs\Breadcrumbs;
use OpenDocs\Page;

class HtmlErrorHandlerForProd implements AppErrorHandler
{
    /**
     * @param mixed $container
     * @return \Closure|mixed
     */
    public function __invoke($container)
    {
        return function ($request, $response, \Throwable $exception) {
            \error_log("The heck: " . $exception->getMessage());
            \error_log(getTextForException($exception));
            $text = "Sorry, an error occurred. ";

            $page = createErrorPage(nl2br($text));
//            $page = Page::errorPage(nl2br($text));
            $html = createPageHtml($page);

            return $response->withStatus(500)
                ->withHeader('Content-Type', 'text/html')
                ->write($html);
        };
    }
}
