<?php

use Osf\InjectionParams;

function injectionParams() : InjectionParams
{
    // These classes will only be created once by the injector.
    $shares = [
        \Auryn\Injector::class,
        \Doctrine\ORM\EntityManager::class,
        \Airbrake\Notifier::class
    ];

    // Alias interfaces (or classes) to the actual types that should be used
    // where they are required.
    $aliases = [
        \VarMap\VarMap::class => \VarMap\Psr7VarMap::class,

        Osf\Factory\ProjectStripeClientFactory\ProjectStripeClientFactory::class =>
            Osf\Factory\ProjectStripeClientFactory\StandardProjectStripeClientFactory::class,

        \Osf\Repo\ProjectCredentialRepo\ProjectStripeConnectRepo::class =>
            \Osf\Repo\ProjectCredentialRepo\DoctrineProjectStripeConnectRepo::class,

        Osf\Repo\ProjectRepo\ProjectRepo::class =>
            Osf\Repo\ProjectRepo\DoctrineProjectRepo::class,

        \Osf\Repo\SkuPriceRepo\SkuPriceRepo::class =>
            \Osf\Repo\SkuPriceRepo\DatabaseSkuPriceRepo::class,
        \Osf\JsonInput\JsonInput::class => \Osf\JsonInput\InputJsonInput::class,

        \Osf\Repo\StripeCheckoutSessionRepo\StripeCheckoutSessionRepo::class =>
        \Osf\Repo\StripeCheckoutSessionRepo\DatabaseStripeCheckoutSessionRepo::class,

        \Osf\Repo\EventRepo\EventRepo::class =>
            \Osf\Repo\EventRepo\RedisEventRepo::class,

        \Osf\Repo\PurchaseOrderRepo\PurchaseOrderRepo::class =>
        \Osf\Repo\PurchaseOrderRepo\PdoPurchaseOrderRepo::class,

        \Osf\RouteInfo\RouteInfo::class =>
            \Osf\RouteInfo\StandardRouteInfo::class,

        \Osf\Notifier\TooMuchMemoryNotifier\TooMuchMemoryNotifier::class =>
            \Osf\Notifier\TooMuchMemoryNotifier\NullTooMuchMemoryNotifier::class,

        \Osf\Repo\PurchaseOrderRateLimitRepo\PurchaseOrderRateLimitRepo::class =>
            \Osf\Repo\PurchaseOrderRateLimitRepo\RedisPurchaseOrderRateLimitRepo::class,
    ];

    // Delegate the creation of types to callables.
    $delegates = [
        \Psr\Log\LoggerInterface::class => 'createLogger',
        \PDO::class => 'createPDO',
        \Doctrine\ORM\EntityManager::class => 'createDoctrineEntityManager',
        \Redis::class => 'createRedis',

        \Osf\MemoryWarningCheck\MemoryWarningCheck::class => 'createMemoryWarningCheck',
        \SlimAuryn\ExceptionMiddleware::class => 'createExceptionMiddlewareForApi',
        \SlimAuryn\SlimAurynInvokerFactory::class => 'createSlimAurynInvokerFactory',

        \Slim\App::class => 'createSlimAppForApi',
        \SlimAuryn\Routes::class => 'createRoutesForApi',

        \Osf\AppErrorHandler\AppErrorHandler::class =>
'createJsonAppErrorHandler',
        \Osf\Data\ApiDomain::class => 'createApiDomain',

        \Osf\Data\StripeWebhookSecret::class => 'createStripeWebhookSecret',

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
