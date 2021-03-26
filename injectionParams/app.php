<?php

use PhpOpenDocs\InjectionParams;

function injectionParams()
{
    // These classes will only be created once by the injector.
    $shares = [
        \Auryn\Injector::class,
        \Slim\Container::class,
        \Slim\App::class,
        \PhpOpenDocs\CSPViolation\RedisCSPViolationStorage::class,
        \PhpOpenDocs\Service\RequestNonce::class,
        \OpenDocs\SectionList::class,
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

//        \OpenDocs\MarkdownRenderer\MarkdownRenderer::class =>
//            \OpenDocs\MarkdownRenderer\MichelfMarkdownRenderer::class,
        \OpenDocs\MarkdownRenderer\MarkdownRenderer::class =>
            \OpenDocs\MarkdownRenderer\CommonMarkRenderer::class,
    ];

    // Delegate the creation of types to callables.
    $delegates = [
        \OpenDocs\SectionList::class => 'createSectionList',
        \PhpOpenDocs\Service\MemoryWarningCheck\MemoryWarningCheck::class => 'createMemoryWarningCheck',
        \SlimAuryn\Routes::class => 'createRoutesForApp',
        \SlimAuryn\ExceptionMiddleware::class => 'createExceptionMiddlewareForApp',
        \SlimAuryn\SlimAurynInvokerFactory::class => 'createSlimAurynInvokerFactory',

        \Slim\Container::class => 'createSlimContainer',
        \Slim\App::class => 'createSlimAppForApp',
        \PhpOpenDocs\AppErrorHandler\AppErrorHandler::class => 'createHtmlAppErrorHandler',
        \PhpOpenDocs\Data\ApiDomain::class => 'createApiDomain',
        \Redis::class => 'createRedis',
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
