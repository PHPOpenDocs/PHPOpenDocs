<?php

use Osf\InjectionParams;

if (function_exists('injectionParams') == false) {

    function injectionParams($testAliases)
    {
        // These classes will only be created once by the injector.
        $shares = [
            \Doctrine\ORM\EntityManager::class,
        ];

        // Alias interfaces (or classes) to the actual types that should be used
        // where they are required.
        $aliases = [
            \Osf\Repo\ProjectCredentialRepo\ProjectStripeConnectRepo::class =>
            \Osf\Repo\ProjectCredentialRepo\DoctrineProjectStripeConnectRepo::class,

            \Osf\Repo\ProjectRepo\ProjectRepo::class =>
            \Osf\Repo\ProjectRepo\DoctrineProjectRepo::class,

//            \Osf\Repo\StripeCheckoutSessionRepo\StripeCheckoutSessionRepo::class =>
//                \Osf\Repo\StripeCheckoutSessionRepo\DatabaseStripeCheckoutSessionRepo::class,
        ];

        // Delegate the creation of types to callables.
        $delegates = [
            \Redis::class => 'createRedis',
            \PDO::class => 'createPDO',
            \Doctrine\ORM\EntityManager::class => 'createDoctrineEntityManager',
        ];

        // Define some params that can be injected purely by name.
        $params = [];

        $prepares = [
        ];

        $defines = [];

        foreach ($testAliases as $className => $implementation) {
            if (is_object($implementation) == true) {
                if ($className === get_class($implementation)) {
                    $shares[$className] = $implementation;
                }
                else {
                    $aliases[$className] = get_class($implementation);
                    $shares[get_class($implementation)] = $implementation;
                }
            }
            else {
                $aliases[$className] = $implementation;
            }
        }


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
