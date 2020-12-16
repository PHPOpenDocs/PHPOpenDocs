<?php

declare (strict_types = 1);

/**
 * This file contains factory functions that create objects from either
 * configuration values, user input or other external data.
 *
 */

use Auryn\Injector;
use PhpOpenDocs\Config;
use Psr\Http\Message\ResponseInterface;
use SlimAuryn\ExceptionMiddleware;

function forbidden(\Auryn\Injector $injector): void
{
    $injector->make("Please don't use this object directly; create a more specific type to use.");
}


function createMemoryWarningCheck(
    Config $config,
    \Auryn\Injector $injector
) : \PhpOpenDocs\Service\MemoryWarningCheck\MemoryWarningCheck {
    $env = Config::getEnvironment();

    if ($env === Config::ENVIRONMENT_LOCAL) {
        return $injector->make(\PhpOpenDocs\Service\MemoryWarningCheck\DevEnvironmentMemoryWarning::class);
    }

    return $injector->make(\PhpOpenDocs\Service\MemoryWarningCheck\ProdMemoryWarningCheck::class);
}


function createRoutesForApp(): \SlimAuryn\Routes
{
    return new \SlimAuryn\Routes(__DIR__ . '/../routes/app_routes.php');
}

/**
 * Creates the ExceptionMiddleware that converts all known app exceptions
 * to nicely formatted pages for the app/user facing sites
 */
function createExceptionMiddlewareForApp(\Auryn\Injector $injector): \SlimAuryn\ExceptionMiddleware
{
    $exceptionHandlers = [
        // We don't use this. All forms are api based.
        /// \Params\Exception\ValidationException::class => 'foo',
        \PhpOpenDocs\Exception\DebuggingCaughtException::class => 'debuggingCaughtExceptionExceptionMapperApp',

        \ParseError::class => 'parseErrorMapperForApp',
    ];

    $resultMappers = getResultMappers($injector);

    return new \SlimAuryn\ExceptionMiddleware(
        $exceptionHandlers,
        $resultMappers
    );
}

///**
// * Creates the ExceptionMiddleware that converts all known app exceptions
// * to nicely formatted pages for the api
// */
//function createExceptionMiddlewareForApi(\Auryn\Injector $injector)
//{
//    $exceptionHandlers = [
//        \Params\Exception\ValidationException::class => 'paramsValidationExceptionMapperApi',
//        \PhpOpenDocs\Exception\DebuggingCaughtException::class => 'debuggingCaughtExceptionExceptionMapperForApi',
//        //        \ParseError::class => 'parseErrorMapper',
////        \PDOException::class => 'pdoExceptionMapper',
//    ];
//
//    return new \SlimAuryn\ExceptionMiddleware(
//        $exceptionHandlers,
//        getResultMappers($injector)
//    );
//}


/**
 * Creates the objects that map StubResponse into PSR7 responses
 * @return mixed
 */
function getResultMappers(\Auryn\Injector $injector)
{
//    $markdownResponseMapperFn = function (
//        \PhpOpenDocs\Response\MarkdownResponse $markdownResponse,
//        ResponseInterface $originalResponse
//    ) use ($injector) {
//        $markdownResponseMapper = $injector->make(\PhpOpenDocs\Service\MarkdownResponseMapper::class);
//
//        return $markdownResponseMapper($markdownResponse, $originalResponse);
//    };

    return [
        \SlimAuryn\Response\StubResponse::class => '\SlimAuryn\ResponseMapper\ResponseMapper::mapStubResponseToPsr7',
//        \PhpOpenDocs\Response\MarkdownResponse::class => $markdownResponseMapperFn,
        ResponseInterface::class => 'SlimAuryn\ResponseMapper\ResponseMapper::passThroughResponse',
        'string' => 'convertStringToHtmlResponse',
    ];
}

function createSlimAurynInvokerFactory(
    \Auryn\Injector $injector,
    \SlimAuryn\RouteMiddlewares $routeMiddlewares
): SlimAuryn\SlimAurynInvokerFactory {
    $resultMappers = getResultMappers($injector);

    return new SlimAuryn\SlimAurynInvokerFactory(
        $injector,
        $routeMiddlewares,
        $resultMappers
    );
}


function createSlimAppForApp(
    Injector $injector,
    \Slim\Container $container,
    \PhpOpenDocs\AppErrorHandler\AppErrorHandler $appErrorHandler
): \Slim\App {
    // quality code.
    $container['foundHandler'] = $injector->make(\SlimAuryn\SlimAurynInvokerFactory::class);

    // TODO - this shouldn't be used in production.
    $container['errorHandler'] = $appErrorHandler;
//  function ($container) use ($appErrorHandler) {
//        return $appErrorHandler;
//    };

    $container['phpErrorHandler'] = $appErrorHandler;
//        function ($container) {
//        return $container['errorHandler'];
//    };

    $app = new \Slim\App($container);

    $app->add($injector->make(\SlimAuryn\ExceptionMiddleware::class));
//    $app->add($injector->make(\PhpOpenDocs\Middleware\ContentSecurityPolicyMiddleware::class));
//    $app->add($injector->make(\PhpOpenDocs\Middleware\BadHeaderMiddleware::class));
//    $app->add($injector->make(\PhpOpenDocs\Middleware\AllowedAccessMiddleware::class));
    $app->add($injector->make(\PhpOpenDocs\Middleware\MemoryCheckMiddleware::class));

    return $app;
}

function createSlimContainer(): \Slim\Container
{
    $container = new \Slim\Container();
    global $request;

    if (isset($request) && $request !== null) {
        $container['request'] = $request;
    }

    return $container;
}


function createHtmlAppErrorHandler(\Auryn\Injector $injector) : \PhpOpenDocs\AppErrorHandler\AppErrorHandler
{
    if (Config::isProductionEnv() === true) {
        return $injector->make(\PhpOpenDocs\AppErrorHandler\HtmlErrorHandlerForProd::class);
    }

    return $injector->make(\PhpOpenDocs\AppErrorHandler\HtmlErrorHandlerForLocalDev::class);
}

function createJsonAppErrorHandler(\Auryn\Injector $injector) : \PhpOpenDocs\AppErrorHandler\AppErrorHandler
{
    if (Config::isProductionEnv() === true) {
        return $injector->make(\PhpOpenDocs\AppErrorHandler\JsonErrorHandlerForProd::class);
    }

    return $injector->make(\PhpOpenDocs\AppErrorHandler\JsonErrorHandlerForLocalDev::class);
}
