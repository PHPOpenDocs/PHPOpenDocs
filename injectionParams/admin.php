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

//        \Osf\Repo\SaleStatusRepo\SaleStatusRepo::class =>
//        \Osf\Repo\SaleStatusRepo\PdoSaleStatusRepo::class,

        \VarMap\VarMap::class => \VarMap\Psr7VarMap::class,

        \Osf\AdminSession\AdminSession::class =>
        \Osf\AdminSession\StandardAdminSession::class,

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

        \Osf\Repo\AdminProjectRepo\AdminProjectRepo::class =>
        \Osf\Repo\AdminProjectRepo\DoctrineAdminProjectRepo::class,

        \Osf\Repo\SkuPriceRepo\SkuPriceRepo::class =>
        \Osf\Repo\SkuPriceRepo\DatabaseSkuPriceRepo::class,

        Osf\Factory\ProjectStripeClientFactory\ProjectStripeClientFactory::class =>
            Osf\Factory\ProjectStripeClientFactory\StandardProjectStripeClientFactory::class,

//        \Osf\Repo\StripePaymentMadeRepo\StripePaymentMadeRepo::class =>
//        \Osf\Repo\StripePaymentMadeRepo\DatabaseStripePaymentMadeRepo::class,

        \Osf\JsonInput\JsonInput::class => \Osf\JsonInput\InputJsonInput::class,
        \Osf\Repo\AdminRepo\AdminRepo::class => \Osf\Repo\AdminRepo\DoctrineAdminRepo::class,

        \Osf\Repo\PaymentRepo\PaymentRepo::class =>
            \Osf\Repo\PaymentRepo\DatabasePaymentRepo::class,

        \Osf\Repo\PurchaseOrderRepo\PurchaseOrderRepo::class =>
            \Osf\Repo\PurchaseOrderRepo\PdoPurchaseOrderRepo::class,

        \Osf\RouteInfo\RouteInfo::class =>
            \Osf\RouteInfo\StandardRouteInfo::class,

        \Osf\Repo\InvoiceRepo\InvoiceRepo::class =>
            \Osf\Repo\InvoiceRepo\DatabaseInvoiceRepo::class,

        \Osf\Jobs\RenderInvoiceToPdf\RenderInvoiceToPdfSender::class =>
            \Osf\Jobs\RenderInvoiceToPdf\DirectRenderInvoiceJobTransport::class,

        \Osf\Repo\PurchaseOrderRateLimitRepo\PurchaseOrderRateLimitRepo::class =>
            \Osf\Repo\PurchaseOrderRateLimitRepo\RedisPurchaseOrderRateLimitRepo::class,

        Sonata\GoogleAuthenticator\GoogleAuthenticatorInterface::class =>
            \Sonata\GoogleAuthenticator\GoogleAuthenticator::class,
    ];

    // Delegate the creation of types to callables.
    $delegates = [
        \PDO::class => 'createPDO',
        \Redis::class => '\createRedis',
        \Psr\Log\LoggerInterface::class => 'createLogger',
        \Twig_Environment::class => 'createTwigForAdmin',
        \Twig\Environment::class => 'createTwigForAdmin',
        \Osf\MemoryWarningCheck\MemoryWarningCheck::class => 'createMemoryWarningCheck',
        \SlimAuryn\Routes::class => 'createRoutesForAdmin',
        \SlimAuryn\ExceptionMiddleware::class => 'createExceptionMiddlewareForAdminSite',

        \Slim\App::class => 'createSlimAppForAdmin',
        \Slim\Container::class => 'createSlimContainer',
        \SlimAuryn\SlimAurynInvokerFactory::class => 'createSlimAurynInvokerFactory',
        \Osf\Data\ServerName::class => 'createServerName',
        \Slim\Middleware\Session::class => 'forbidden',
        \Osf\Middleware\Session::class => 'createMiddlewareSession',
        \Doctrine\ORM\EntityManager::class => 'createDoctrineEntityManager',
        \Osf\Stripe\PlatformStripeClient\StandardPlatformStripeClient::class => 'createPlatformStripeClient',
        \Osf\AppErrorHandler\AppErrorHandler::class => 'createHtmlAppErrorHandler',
        \Osf\Data\ApiDomain::class => 'createApiDomain',
        \Osf\Data\AdminDomain::class => 'createAdminDomain',
        \Osf\Data\InternalDomain::class => 'createInternalDomain',
        \Osf\Jobs\RenderInvoiceToPdf\RenderInvoiceToPdfProcessor::class => 'createRenderInvoiceToPdfProcessor',

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
