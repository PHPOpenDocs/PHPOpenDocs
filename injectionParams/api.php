<?php

use PhpOpenDocs\InjectionParams;

function injectionParams() : InjectionParams
{
    // These classes will only be created once by the injector.
    $shares = [
        \Auryn\Injector::class,
//        \Doctrine\ORM\EntityManager::class,
    ];

    // Alias interfaces (or classes) to the actual types that should be used
    // where they are required.
    $aliases = [
        \VarMap\VarMap::class => \VarMap\Psr7VarMap::class,

        \PhpOpenDocs\Repo\PhpBugsStorage\PhpBugsStorage::class =>
            \PhpOpenDocs\Repo\PhpBugsStorage\RedisPhpBugsStorage::class,
   ];

    // Delegate the creation of types to callables.
    $delegates = [
        \Redis::class => 'createRedis',
        \PhpOpenDocs\Service\MemoryWarningCheck\MemoryWarningCheck::class => 'createMemoryWarningCheck',
        \SlimAuryn\ExceptionMiddleware::class => 'createExceptionMiddlewareForApi',
        \SlimAuryn\SlimAurynInvokerFactory::class => 'createSlimAurynInvokerFactory',
        \Slim\App::class => 'createSlimAppForApi',
        \SlimAuryn\Routes::class => 'createRoutesForApi',

        \PhpOpenDocs\AppErrorHandler\AppErrorHandler::class =>
'createJsonAppErrorHandler',
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
