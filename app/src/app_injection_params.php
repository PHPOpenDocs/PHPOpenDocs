<?php


use AurynConfig\InjectionParams;

function injectionParams()
{
    // These classes will only be created once by the injector.
    $shares = [
        \Auryn\Injector::class,
        \Slim\App::class,
        \PhpOpenDocs\CSPViolation\RedisCSPViolationStorage::class,
        \PhpOpenDocs\Service\RequestNonce::class,
        \OpenDocs\SectionList::class,
        createInternalsSection(),
        createLearningSection(),
        createMerchSection(),
        createNamingThingsSection(),
        createSystemSection(),
        createRfcCodexSection(),
    ];

    // Alias interfaces (or classes) to the actual types that should be used
    // where they are required.
    $aliases = [
        \VarMap\VarMap::class => \VarMap\Psr7VarMap::class,
        \PhpOpenDocs\Service\TooMuchMemoryNotifier\TooMuchMemoryNotifier::class =>
            \PhpOpenDocs\Service\TooMuchMemoryNotifier\NullTooMuchMemoryNotifier::class,
        \PhpOpenDocs\CSPViolation\CSPViolationReporter::class =>
            \PhpOpenDocs\CSPViolation\RedisCSPViolationStorage::class,
        \PhpOpenDocs\CSPViolation\CSPViolationStorage::class =>
            \PhpOpenDocs\CSPViolation\RedisCSPViolationStorage::class,
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
        \PhpOpenDocs\Service\MemoryWarningCheck\MemoryWarningCheck::class => 'createMemoryWarningCheck',
        \PhpOpenDocs\Middleware\ExceptionToErrorPageResponseMiddleware::class =>
            'createExceptionToErrorPageResponseMiddleware',
        \Slim\App::class => 'createSlimAppForApp',
        \PhpOpenDocs\AppErrorHandler\AppErrorHandler::class => 'createHtmlAppErrorHandler',
        \Redis::class => 'createRedis',
        \PhpOpenDocs\Data\ApiDomain::class => 'createApiDomain',
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
