<?php

use PhpOpenDocs\InjectionParams;

function injectionParams() : InjectionParams
{
    // These classes will only be created once by the injector.
    $shares = [
        \Auryn\Injector::class,
        \Doctrine\ORM\EntityManager::class,

    ];

    // Alias interfaces (or classes) to the actual types that should be used
    // where they are required.
    $aliases = [
        \VarMap\VarMap::class => \VarMap\Psr7VarMap::class,

   ];

    // Delegate the creation of types to callables.
    $delegates = [
        \Psr\Log\LoggerInterface::class => 'createLogger',
        \PDO::class => 'createPDO',
        \Doctrine\ORM\EntityManager::class => 'createDoctrineEntityManager',
        \Redis::class => 'createRedis',


        \SlimAuryn\ExceptionMiddleware::class => 'createExceptionMiddlewareForApi',
        \SlimAuryn\SlimAurynInvokerFactory::class => 'createSlimAurynInvokerFactory',

        \Slim\App::class => 'createSlimAppForApi',
        \SlimAuryn\Routes::class => 'createRoutesForApi',

        \Osf\AppErrorHandler\AppErrorHandler::class =>
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
