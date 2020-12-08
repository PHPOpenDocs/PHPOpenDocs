<?php

declare(strict_types = 1);

namespace PhpOpenDocs\AppErrorHandler;

use PhpOpenDocs\App;
use SlimAuryn\ResponseMapper\ResponseMapper;
use SlimAuryn\Response\HtmlResponse;

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

            $text .= App::ERROR_CAUGHT_BY_ERROR_HANDLER_MESSAGE;

            $stubResponse = new HtmlResponse(nl2br($text), [], 500);

            \error_log($text);

            $response = ResponseMapper::mapStubResponseToPsr7($stubResponse, $response);

            return $response;
        };
    }
}
