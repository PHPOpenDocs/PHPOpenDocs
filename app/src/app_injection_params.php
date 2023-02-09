<?php


use AurynConfig\InjectionParams;

function injectionParams()
{
    // These classes will only be created once by the injector.
    $shares = [
        \Auryn\Injector::class,
        \Slim\App::class,
        \PHPOpenDocs\CSPViolation\RedisCSPViolationStorage::class,
        \PHPOpenDocs\Service\RequestNonce::class,
        \OpenDocs\SectionList::class,
//        createInternalsSection(),
//        createLearningSection(),
//        createMerchSection(),
//        createNamingThingsSection(),
//        createSystemSection(),
//        createRfcCodexSection(),
    ];

    // Alias interfaces (or classes) to the actual types that should be used
    // where they are required.
    $aliases = [
        \VarMap\VarMap::class => \VarMap\Psr7VarMap::class,
        \PHPOpenDocs\Service\TooMuchMemoryNotifier\TooMuchMemoryNotifier::class =>
            \PHPOpenDocs\Service\TooMuchMemoryNotifier\NullTooMuchMemoryNotifier::class,
        \PHPOpenDocs\CSPViolation\CSPViolationReporter::class =>
            \PHPOpenDocs\CSPViolation\RedisCSPViolationStorage::class,
        \PHPOpenDocs\CSPViolation\CSPViolationStorage::class =>
            \PHPOpenDocs\CSPViolation\RedisCSPViolationStorage::class,
        \OpenDocs\MarkdownRenderer\MarkdownRenderer::class =>
            \OpenDocs\MarkdownRenderer\CommonMarkRenderer::class,
        \OpenDocs\UrlFetcher\UrlFetcher::class =>
            \OpenDocs\UrlFetcher\RedisCachedUrlFetcher::class,
        \OpenDocs\ExternalMarkdownRenderer\ExternalMarkdownRenderer::class =>
            \OpenDocs\ExternalMarkdownRenderer\StandardExternalMarkdownRenderer::class,
        Psr\Http\Message\ResponseFactoryInterface::class =>
            \Laminas\Diactoros\ResponseFactory::class,
    ];

    // Delegate the creation of types to callables.
    $delegates = [
        \OpenDocs\SectionList::class => 'createSectionList',
        \PHPOpenDocs\Service\MemoryWarningCheck\MemoryWarningCheck::class => 'createMemoryWarningCheck',
        \PHPOpenDocs\Middleware\ExceptionToErrorPageResponseMiddleware::class =>
            'createExceptionToErrorPageResponseMiddleware',
        \Slim\App::class => 'createSlimAppForApp',
        \PHPOpenDocs\AppErrorHandler\AppErrorHandler::class => 'createHtmlAppErrorHandler',
        \Redis::class => 'createRedis',
        \PHPOpenDocs\Data\ApiDomain::class => 'createApiDomain',
        \OpenDocs\RequestPath::class => 'createRequestPath',
    ];

    // Define some params that can be injected purely by name.
    $params = [];

    $prepares = [
    ];

    $defines = [];

    $injectionParams = new InjectionParams(
        $shares,
        $aliases,
        $delegates,
        $params,
        $prepares,
        $defines
    );

    return $injectionParams;
}

function getSectionInjectionParams()
{
    // These classes will only be created once by the injector.
    $shares = [
    ];

    // Alias interfaces (or classes) to the actual types that should be used
    // where they are required.
    $aliases = [
        \OpenDocs\MarkdownRenderer\MarkdownRenderer::class => \OpenDocs\MarkdownRenderer\CommonMarkRenderer::class,
    ];

    // Delegate the creation of types to callables.
    $delegates = [
    ];


    // Define some params that can be injected purely by name.
    $params = [];

    $prepares = [
    ];

    $defines = [];

    $injectionParams = new InjectionParams(
        $shares,
        $aliases,
        $delegates,
        $params,
        $prepares,
        $defines
    );

    return $injectionParams;
}
