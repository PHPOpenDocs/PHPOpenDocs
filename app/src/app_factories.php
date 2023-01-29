<?php

declare(strict_types = 1);

use Auryn\Injector;
use PhpOpenDocs\Config;
use Psr\Http\Message\ResponseInterface;
use SlimAuryn\AurynCallableResolver;
use Laminas\Diactoros\ResponseFactory;
use PhpOpenDocs\Middleware\ExceptionToErrorPageResponseMiddleware;
use OpenDocs\SiteHtml\PageResponseGenerator;
use PhpOpenDocs\App;

/**
 * Creates the ExceptionMiddleware that converts all known app exceptions
 * to nicely formatted pages for the app/user facing sites
 */
function createExceptionToErrorPageResponseMiddleware(Injector $injector): ExceptionToErrorPageResponseMiddleware
{
    // TODO - the key is un-needed. Matching the exception handler to the
    // type of exception could be done via reflection.
    $exceptionHandlers = [
        \PhpOpenDocs\Exception\DebuggingCaughtException::class => 'renderDebuggingCaughtExceptionToHtml',
        \Auryn\InjectionException::class => 'renderAurynInjectionExceptionToHtml',
        \OpenDocs\MarkdownRenderer\MarkdownRendererException::class => 'renderMarkdownRendererException',
        \ParseError::class => 'renderParseErrorToHtml',
        \Throwable::class => 'genericExceptionHandler' // should be last
    ];

    return new ExceptionToErrorPageResponseMiddleware(
        $injector->make(PageResponseGenerator::class),
        $exceptionHandlers
    );
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
 * @param Injector $injector
 * @param \PhpOpenDocs\AppErrorHandler\AppErrorHandler $appErrorHandler
 * @return \Slim\App
 * @throws \Auryn\InjectionException
 */
function createSlimAppForApp(
    Injector $injector,
    \PhpOpenDocs\AppErrorHandler\AppErrorHandler $appErrorHandler
): \Slim\App {

    $callableResolver = new AurynCallableResolver(
        $injector,
        $resultMappers = getResultMappers($injector)
    );

    $app = new \Slim\App(
    /* ResponseFactoryInterface */ $responseFactory = new ResponseFactory(),
        /* ?ContainerInterface */ $container = null,
        /* ?CallableResolverInterface */ $callableResolver,
        /* ?RouteCollectorInterface */ $routeCollector = null,
        /* ?RouteResolverInterface */ $routeResolver = null,
        /* ?MiddlewareDispatcherInterface */ $middlewareDispatcher = null
    );

    $app->add($injector->make(\PhpOpenDocs\Middleware\ExceptionToErrorPageResponseMiddleware::class));
    $app->add($injector->make(\PhpOpenDocs\Middleware\ContentSecurityPolicyMiddleware::class));
//    $app->add($injector->make(\Bristolian\Middleware\BadHeaderMiddleware::class));
//    $app->add($injector->make(\Bristolian\Middleware\AllowedAccessMiddleware::class));
    $app->add($injector->make(\PhpOpenDocs\Middleware\MemoryCheckMiddleware::class));

    return $app;
}


function createApiDomain(Config $config)
{
    if ($config->isProductionEnv()) {
        return new \PhpOpenDocs\Data\ApiDomain("https://api.phpopendocs.com");
    }

    return new \PhpOpenDocs\Data\ApiDomain("http://local.api.phpopendocs.com");
}

/**
 * Creates the objects that map StubResponse into PSR7 responses
 * @return mixed
 */
function getResultMappers(\Auryn\Injector $injector)
{
    return [
        \SlimAuryn\Response\StubResponse::class => '\SlimAuryn\mapStubResponseToPsr7',
        \OpenDocs\Page::class => 'mapOpenDocsPageToPsr7',
        ResponseInterface::class => 'SlimAuryn\passThroughResponse',
        'string' => 'convertStringToHtmlResponse',
    ];
}


function createInternalsSection()
{
    return new \Internals\InternalsSection(
        '/internals',
        'Internals',
        'Info about PHP core development',
        new \Internals\InternalsSectionInfo()
    );
}

function createLearningSection()
{
    return new \Learning\LearningSection(
        '/learning',
        'Learning',
        'So you want/have been forced to learn PHP?',
        new \Learning\LearningSectionInfo
    );
}

function createMerchSection()
{
    return new \Merch\MerchSection(
        '/merch',
        'Merch',
        'PHP related things to buy',
        new \Merch\MerchSectionInfo()
    );
}



function createNamingThingsSection()
{
    return new \NamingThings\NamingThingsSection(
        '/naming',
        'Naming',
        'Naming things',
        new \NamingThings\NamingThingsSectionInfo
    );
}

function createSystemSection()
{
    return new \PhpOpenDocs\SystemSection(
        '/system',
        'System',
        'Site system stuff...',
        new \PhpOpenDocs\SystemSectionInfo
    );
}

function createRfcCodexSection()
{
    return new \RfcCodexOpenDocs\RfcCodexSection(
        '/rfc_codex',
        'RFC Codex',
        "Discussions ideas for how PHP can be improved, why some ideas haven't come to fruition yet.",
        new \RfcCodexOpenDocs\RfcCodexSectionInfo()
    );
}


function createSponsoringSection()
{
    return new \OpenDocs\Section(
        '/sponsoring',
        'Sponsoring',
        'How to give money to people who work on PHP core or documentation.',
        new \PHPFunding\PHPFundingSectionInfo
    );
}

function createSectionList(): \OpenDocs\SectionList
{
    $sections = [];

    $sections[] = createLearningSection();
    $sections[] = createNamingThingsSection();
//        new \OpenDocs\Section(
//        '/naming',
//        'Naming things',
//        'Naming things is one of the most difficult problems ever.',
//        new \NamingThings\NamingThingsSectionInfo
//    );

    $sections[] = createRfcCodexSection();
//        new \OpenDocs\Section(
//        '/rfc_codex',
//        'RFC Codex',
//        "Discussions ideas for how PHP can be improved, why some ideas haven't come to fruition yet.",
//        new \RfcCodexOpenDocs\RfcCodexSectionInfo()
//    );

    $sections[] = createMerchSection();
    $sections[] = createSystemSection();
    $sections[] = createSponsoringSection();

//    $sections[] = new \OpenDocs\Section(
//        '/work',
//        'Work',
//        'Distributing the work load required to support PHP',
//        new \Work\WorkSectionInfo
//    );

    $sections[] = createInternalsSection();

    return new \OpenDocs\SectionList($sections);
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

                $breadcrumbsFactory = new \OpenDocs\BreadcrumbsFactory($section);
                $injector->share($breadcrumbsFactory);
                foreach ($fullRouteInfo->getRouteParams()->getAll() as $key => $value) {
                    $injector->defineParam($key, $value);
                }

                $injector->share(createLearningSection());
                $injector->share(createNamingThingsSection());
                $injector->share(createInternalsSection());
                $injector->share(createSystemSection());
                $injector->share(createRfcCodexSection());

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
        \PhpOpenDocs\Exception\DebuggingCaughtException::class => 'debuggingCaughtExceptionExceptionMapperApp',
        \Auryn\InjectionException::class => 'renderAurynInjectionException',
        \OpenDocs\MarkdownRenderer\MarkdownRendererException::class => 'renderMarkdownRendererException',

        \ParseError::class => 'parseErrorMapperForApp',
    ];

    $resultMappers = getResultMappers($injector);

    return new \SlimAuryn\ExceptionMiddleware(
        $exceptionHandlers,
        $resultMappers
    );
}



/**
 * @return Redis
 * @throws Exception
 */
function createRedis()
{
    $redisInfo = Config::get(Config::PHPOPENDOCS_REDIS_INFO);

    $redis = new Redis();
    $redis->connect(
        $redisInfo['host'],
        $redisInfo['port'],
        $timeout = 2.0
    );
    $redis->auth($redisInfo['password']);
    $redis->ping();

    return $redis;
}
