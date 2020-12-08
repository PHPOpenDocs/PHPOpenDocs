<?php

declare(strict_types = 1);

namespace PhpOpenDocs\AppErrorHandler;

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

            return $response->withStatus(500)
                ->withHeader('Content-Type', 'text/html')
                ->write($text);
        };
    }
}
