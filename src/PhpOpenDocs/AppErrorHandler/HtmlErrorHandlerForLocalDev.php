<?php

declare(strict_types = 1);

namespace PhpOpenDocs\AppErrorHandler;

use PhpOpenDocs\App;
use SlimAuryn\ResponseMapper\ResponseMapper;
use SlimAuryn\Response\HtmlResponse;
use OpenDocs\Page;
use OpenDocs\Breadcrumbs;

class HtmlErrorHandlerForLocalDev implements AppErrorHandler
{
    /**
     * @param mixed $container
     * @return \Closure|mixed
     */
    public function __invoke($container)
    {
        /**
         * @param mixed $request
         * @param mixed $response
         * @param mixed $exception
         * @return mixed
         */
        return function ($request, $response, $exception) {
            /** @var \Throwable $exception */
            $text = getTextForException($exception);
            /** This is to allow testing */
            $text .= App::ERROR_CAUGHT_BY_ERROR_HANDLER_MESSAGE;
            $page = createErrorPage(nl2br($text));

            $html = createPageHtml(null, $page, new Breadcrumbs);
            $stubResponse = new HtmlResponse($html, [], 500);
            \error_log($text);
            $response = ResponseMapper::mapStubResponseToPsr7($stubResponse, $response);

            return $response;
        };
    }
}
