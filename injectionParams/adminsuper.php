<?php

use Osf\InjectionParams;

function injectionParams()
{
    // These classes will only be created once by the injector.
    $shares = [
        \Redis::class,
        \Twig_Environment::class,
        \Auryn\Injector::class,
        \Slim\Container::class,
        \Slim\App::class,
        \Osf\CSPViolation\RedisCSPViolationStorage::class,
        \Osf\Service\RequestNonce::class,
        \Osf\BreadcrumbsDisplay::class,
        \Doctrine\ORM\EntityManager::class,

    ];

    // Alias interfaces (or classes) to the actual types that should be used
    // where they are required.
    $aliases = [
        \Osf\Notifier\TooMuchMemoryNotifier\TooMuchMemoryNotifier::class =>
        \Osf\Notifier\TooMuchMemoryNotifier\NullTooMuchMemoryNotifier::class,

        \Osf\CSPViolation\CSPViolationReporter::class =>
            \Osf\CSPViolation\RedisCSPViolationStorage::class,

        \Osf\CSPViolation\CSPViolationStorage::class =>
            \Osf\CSPViolation\RedisCSPViolationStorage::class,

        \Osf\Repo\SaleStatusRepo\SaleStatusRepo::class =>
        \Osf\Repo\SaleStatusRepo\PdoSaleStatusRepo::class,

        \VarMap\VarMap::class => \VarMap\Psr7VarMap::class,

        \Osf\Repo\SuperLoginRepo\SuperLoginRepo::class =>
        \Osf\Repo\SuperLoginRepo\InMemorySuperLoginRepo::class,

        Osf\SuperSession\SuperSession::class => \Osf\SuperSession\StandardSuperSession::class,

        \Osf\Repo\ManageAdminsRepo\ManageAdminsRepo::class =>
        \Osf\Repo\ManageAdminsRepo\DatabaseManageAdminsRepo::class,

        \Osf\Repo\ProjectRepo\ProjectRepo::class =>
        \Osf\Repo\ProjectRepo\DoctrineProjectRepo::class,

        \Osf\Repo\SkuRepo\SkuRepo::class =>
        \Osf\Repo\SkuRepo\DatabaseSkuRepo::class,

        \Osf\Stripe\PlatformStripeClient\PlatformStripeClient::class =>
        \Osf\Stripe\PlatformStripeClient\StandardPlatformStripeClient::class,

        \Osf\Repo\ProjectCredentialRepo\ProjectStripeConnectRepo::class =>
        \Osf\Repo\ProjectCredentialRepo\DoctrineProjectStripeConnectRepo::class,

        \Osf\Repo\StripePaymentMadeRepo\StripePaymentMadeRepo::class =>
            \Osf\Repo\StripePaymentMadeRepo\DatabaseStripePaymentMadeRepo::class,

        \Osf\JsonInput\JsonInput::class => \Osf\JsonInput\InputJsonInput::class,

        \Osf\Repo\EventRepo\EventRepo::class =>
            \Osf\Repo\EventRepo\RedisEventRepo::class,
    ];

    // Delegate the creation of types to callables.
    $delegates = [
        \PDO::class => 'createPDO',
        \Redis::class => '\createRedis',
        \Psr\Log\LoggerInterface::class => 'createLogger',
        \Twig_Environment::class => 'createTwigForSuperAdmin',
        \Twig\Environment::class => 'createTwigForSuperAdmin',
        \Osf\MemoryWarningCheck\MemoryWarningCheck::class => 'createMemoryWarningCheck',
        \SlimAuryn\Routes::class => 'createRoutesForSuperAdmin',
        \SlimAuryn\ExceptionMiddleware::class => 'createExceptionMiddlewareForSuperAdminSite',

        \Slim\Container::class => 'createSlimContainer',
        \Slim\App::class => 'createSlimAppForSuperAdmin',
        \SlimAuryn\SlimAurynInvokerFactory::class => 'createSlimAurynInvokerFactory',

        \Osf\Data\ServerName::class => 'createServerName',
        \Slim\Middleware\Session::class => 'forbidden',
        \Osf\Middleware\Session::class => 'createMiddlewareSessionForSuper',
        \Doctrine\ORM\EntityManager::class => 'createDoctrineEntityManager',

        \Osf\Middleware\AllowedAccessMiddleware::class => 'createAllowedAccessMiddlewareForSuper',

        \Osf\Repo\SuperLoginRepo\InMemorySuperLoginRepo::class => 'createInMemorySuperLoginRepo',
        \Osf\AppErrorHandler\AppErrorHandler::class => 'createHtmlAppErrorHandler',
        \Osf\Data\ApiDomain::class => 'createApiDomain',
    ];

//    if (getConfig(['example', 'direct_sending_no_queue']) === true) {
//    }


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
