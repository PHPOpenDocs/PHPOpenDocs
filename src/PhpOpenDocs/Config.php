<?php

declare(strict_types = 1);

namespace PhpOpenDocs;

class Config
{
    const ENVIRONMENT_LOCAL = 'local';
    const ENVIRONMENT_PROD = 'prod';

    const EXAMPLE_DATABASE_INFO = ['phpopendocs', 'database'];

    const EXAMPLE_REDIS_INFO = ['phpopendocs', 'redis'];

    const EXAMPLE_EXCEPTION_LOGGING = ['phpopendocs', 'exception_logging'];

    const OSF_CORS_ALLOW_ORIGIN = ['phpopendocs', 'cors', 'allow_origin'];

    const OSF_ENVIRONMENT = ['phpopendocs', 'env'];

//    const OSF_ALLOWED_ACCESS_CIDRS = ['phpopendocs', 'allowed_access_cidrs'];

    // This is used for naming the server for external services. e.g.
    // Google authenticator. It should have a unique name per environment
    const OSF_SERVER_NAME = ['phpopendocs', 'server_name'];



    public static function get($index): string
    {
        return getConfig($index);
    }

    public static function testValuesArePresent()
    {
        $rc = new \ReflectionClass(self::class);
        $constants = $rc->getConstants();

        foreach ($constants as $constant) {
            $value = getConfig($constant);
        }
    }

    public function getCorsAllowOriginForApi()
    {
        return $this->get(self::OSF_CORS_ALLOW_ORIGIN);
    }

    public static function getEnvironment()
    {
        return getConfig(self::OSF_ENVIRONMENT);
    }


    public static function isProductionEnv()
    {
        if (self::getEnvironment() === Config::ENVIRONMENT_LOCAL) {
            return false;
        }

        return true;
    }
}
