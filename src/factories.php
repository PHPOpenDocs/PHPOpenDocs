<?php

declare (strict_types = 1);

/**
 * This file contains factory functions that create objects from either
 * configuration values, user input or other external data.
 *
 * We deliberately do not import most of the classes referenced in this file to the current namespace
 * as that would make it harder to read, not easier.
 */

use Auryn\Injector;
use PhpOpenDocs\App;
use PhpOpenDocs\Config;
use Psr\Http\Message\ResponseInterface;

function forbidden(\Auryn\Injector $injector): void
{
    $injector->make("Please don't use this object directly; create a more specific type to use.");
}


function createMemoryWarningCheck(
    Config $config,
    \Auryn\Injector $injector
) : \PhpOpenDocs\Service\MemoryWarningCheck\MemoryWarningCheck {
    $env = Config::getEnvironment();

    if ($env === App::ENVIRONMENT_LOCAL) {
        return $injector->make(\PhpOpenDocs\Service\MemoryWarningCheck\DevEnvironmentMemoryWarning::class);
    }

    return $injector->make(\PhpOpenDocs\Service\MemoryWarningCheck\ProdMemoryWarningCheck::class);
}


function createRoutesForApp(\OpenDocs\SectionList $sectionList)//: \SlimAuryn\Routes
{
    $routes = new \PhpOpenDocs\SlimRoutesExtended();

    $injector = new \Auryn\Injector();
    $injectionParams = getSectionInjectionParams();
    $injectionParams->addToInjector($injector);

    foreach ($sectionList->getSections() as $section) {
        $sectionInfo = $section->getSectionInfo();
        foreach ($sectionInfo->getRoutes() as $route) {
            $fullPath = $section->getPrefix() . $route->getPath();
            $routeCallable = $route->getCallable();
            $sectionFn = function (\PhpOpenDocs\FullRouteInfo $fullRouteInfo)
 use ($section, $routeCallable, $injector) {
                $injector = clone $injector;
                $injector->share($section);

                foreach ($fullRouteInfo->getRouteParams()->getAll() as $key => $value) {
                    $injector->defineParam($key, $value);
                }

                $page = $injector->execute($routeCallable);

                return convertPageToHtmlResponse($section, $page);
            };

            $routes->addRoute($fullPath, $route->getMethod(), $sectionFn);
        }
    }

    $standardRoutes = require __DIR__ . '/../routes/app_routes.php';
    foreach ($standardRoutes as $standardRoute) {
        list($path, $method, $callable) = $standardRoute;
        $routes->addRoute($path, $method, $callable);
    }

    return $routes;
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


/**
 * Creates the objects that map StubResponse into PSR7 responses
 * @return mixed
 */
function getResultMappers(\Auryn\Injector $injector)
{
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
    $container['phpErrorHandler'] = $appErrorHandler;

    $app = new \Slim\App($container);
    $app->add($injector->make(\SlimAuryn\ExceptionMiddleware::class));
    $app->add($injector->make(\PhpOpenDocs\Middleware\ContentSecurityPolicyMiddleware::class));
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

/**
 * @return Redis
 * @throws Exception
 */
function createRedis()
{
    $redisInfo = Config::get(Config::PHPOPENDOCS_REDIS_INFO);

    $redis = new Redis();
    $redis->connect($redisInfo['host'], $redisInfo['port']);
    $redis->auth($redisInfo['password']);
    $redis->ping();

    return $redis;
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

/**
 * Creates the ExceptionMiddleware that converts all known app exceptions
 * to nicely formatted pages for the api
 */
function createExceptionMiddlewareForApi(\Auryn\Injector $injector)
{
    $exceptionHandlers = [
        \Params\Exception\ValidationException::class => 'paramsValidationExceptionMapperApi',
//        \ASVoting\Exception\DebuggingCaughtException::class => 'debuggingCaughtExceptionExceptionMapperForApi',
        //        \ParseError::class => 'parseErrorMapper',
//        \PDOException::class => 'pdoExceptionMapper',
    ];

    return new \SlimAuryn\ExceptionMiddleware(
        $exceptionHandlers,
        getResultMappers($injector)
    );
}

function createSlimAppForApi(
    Injector $injector,
    \Slim\Container $container,
    \PhpOpenDocs\AppErrorHandler\AppErrorHandler $appErrorHandler
) {
    // quality code.
    $container['foundHandler'] = $injector->make(\SlimAuryn\SlimAurynInvokerFactory::class);

    // TODO - this shouldn't be used in production.
    $container['errorHandler'] = $appErrorHandler;

    $container['phpErrorHandler'] = $appErrorHandler;
//        function ($container) {
//        return $container['errorHandler'];
//    };

    $app = new \Slim\App($container);

    $app->add($injector->make(\SlimAuryn\ExceptionMiddleware::class));
    $app->add($injector->make(\PhpOpenDocs\Middleware\MemoryCheckMiddleware::class));
    $app->add($injector->make(\PhpOpenDocs\Middleware\AllowAllCors::class));

    return $app;
}

function createRoutesForApi()
{
    return new \SlimAuryn\Routes(__DIR__ . '/../routes/api_routes.php');
}

function createSectionList(): \OpenDocs\SectionList
{
    $sections = [];

    $sections[] = new \OpenDocs\Section(
        '/learning',
        'Learning',
        'So you want/have been forced to learn PHP?',
        new \Learning\LearningSectionInfo
    );

    $sections[] = new \OpenDocs\Section(
        '/naming',
        'Naming things',
        'Naming things is one of the most difficult problems ever.',
        new \NamingThings\NamingThingsSectionInfo
    );

    $sections[] = new \OpenDocs\Section(
        '/rfc_codex',
        'RFC Codex',
        "Discussions ideas for how PHP can be improved, why some ideas haven't come to fruition yet.",
        new \RfcCodexOpenDocs\RfcCodexSectionInfo()
    );

    $sections[] = new \OpenDocs\Section(
        '/sponsoring',
        'Sponsoring',
        'How to give money to people who work on PHP core or documentation.',
        new \PHPFunding\PHPFundingSectionInfo
    );


    $sections[] = new \OpenDocs\Section(
        '/work',
        'Work',
        'Distributing the work load required to support PHP',
        new \Work\WorkSectionInfo
    );

//    $sections[] = new \OpenDocs\Section(
//        '/internals',
//        'Internals',
//        "Scary details of how PHP works internally, and how to write internal or extension code."
//    );

    return new \OpenDocs\SectionList($sections);
}

function createApiDomain(Config $config)
{
    if ($config->isProductionEnv()) {
        return new \PhpOpenDocs\Data\ApiDomain("https://api.phpopendocs.com");
    }

    return new \PhpOpenDocs\Data\ApiDomain("http://local.api.phpopendocs.com");
}