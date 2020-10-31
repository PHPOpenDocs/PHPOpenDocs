<?php

use Osf\InjectionParams;
use Osf\Config;


if (function_exists('injectionParams') == false) {

    function injectionParams() : InjectionParams
    {
        // These classes will only be created once by the injector.
        $shares = [
            \Doctrine\ORM\EntityManager::class,
            \Redis::class,
            \Airbrake\Notifier::class
        ];

        // Alias interfaces (or classes) to the actual types that should be used
        // where they are required.
        $aliases = [
            \Osf\Service\LocalStorage\InvoiceLocalStorage\InvoiceLocalStorage::class =>
            \Osf\Service\LocalStorage\InvoiceLocalStorage\FileInvoiceLocalStorage::class,
            \Osf\Queue\PrintUrlToPdfQueue::class => \Osf\Queue\RedisPrintUrlToPdfQueue::class,

            Osf\Repo\SkuRepo\SkuRepo::class => Osf\Repo\SkuRepo\DatabaseSkuRepo::class,
            Osf\Repo\ProjectRepo\ProjectRepo::class =>
                Osf\Repo\ProjectRepo\DoctrineProjectRepo::class,

            \Osf\Repo\SkuPriceRepo\SkuPriceRepo::class =>
            \Osf\Repo\SkuPriceRepo\DatabaseSkuPriceRepo::class,

            \Osf\Queue\PurchaseOrderNotify\PurchaseOrderNotifyQueue::class =>
            \Osf\Queue\PurchaseOrderNotify\RedisPurchaseOrderNotifyQueue::class,

            \Osf\PurchaseOrderNotifier\PurchaseOrderNotifier::class =>
            \Osf\PurchaseOrderNotifier\TwilioPurchaseOrderNotifier::class,

            \Osf\Repo\AdminRepo\AdminRepo::class =>
            \Osf\Repo\AdminRepo\DoctrineAdminRepo::class,

            \Osf\Repo\ManageAdminsRepo\ManageAdminsRepo::class =>
            \Osf\Repo\ManageAdminsRepo\DatabaseManageAdminsRepo::class,

            \Osf\Repo\StripeCheckoutSessionRepo\StripeCheckoutSessionRepo::class =>
            \Osf\Repo\StripeCheckoutSessionRepo\DatabaseStripeCheckoutSessionRepo::class,

            \Osf\Repo\StripeEventRepo\StripeEventRepo::class =>
            \Osf\Repo\StripeEventRepo\RedisStripeEventRepo::class,

            Osf\Event\Processor\StripeEventProcessor\StripeEventProcessor::class =>
                \Osf\Event\Processor\StripeEventProcessor\StandardStripeEventProcessor::class,

            Osf\Factory\ProjectStripeClientFactory\ProjectStripeClientFactory::class =>
                Osf\Factory\ProjectStripeClientFactory\StandardProjectStripeClientFactory::class,

            \Osf\Repo\ProjectCredentialRepo\ProjectStripeConnectRepo::class =>
                \Osf\Repo\ProjectCredentialRepo\DoctrineProjectStripeConnectRepo::class,

            \Osf\Repo\PaymentRepo\PaymentRepo::class =>
            \Osf\Repo\PaymentRepo\DatabasePaymentRepo::class,


            \Osf\Repo\NotificationRepo\PurchaseOrderNotificationRepo::class =>
            \Osf\Repo\NotificationRepo\DatabasePurchaseOrderNotificationRepo::class,

            \Osf\Repo\PurchaseOrderRepo\PurchaseOrderRepo::class =>
                \Osf\Repo\PurchaseOrderRepo\PdoPurchaseOrderRepo::class,

            \Osf\Service\NotificationSender\NotificationSender::class =>
                \Osf\Service\NotificationSender\LiveNotificationSender::class,

            \Osf\Repo\PurchaseOrderRateLimitRepo\PurchaseOrderRateLimitRepo::class =>
                \Osf\Repo\PurchaseOrderRateLimitRepo\RedisPurchaseOrderRateLimitRepo::class,
            
        ];


        $environment = getConfig(Config::OSF_ENVIRONMENT);

        if ($environment !== 'production') {
            $aliases[\Osf\Service\NotificationSender\NotificationSender::class] =
                \Osf\Service\NotificationSender\LocalDevNotificationSender::class;
        }

        // Delegate the creation of types to callables.
        $delegates = [
            \PDO::class => 'createPDO',
            \Redis::class => 'createRedis',
            \Doctrine\ORM\EntityManager::class => 'createDoctrineEntityManager',
            \Osf\Service\LocalStorage\InvoiceLocalStorage\FileInvoiceLocalStorage::class => 'createFileInvoiceLocalStorage',
//            \Osf\CliController\RenderInvoiceToPDFProcessor::class => 'createPdfGeneratorFromConfig',
            \Osf\Service\TwilioClient::class => 'createTwilioClientFromConfig',
            \Osf\Data\InternalDomain::class => 'createInternalDomain',
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
}


return injectionParams();
