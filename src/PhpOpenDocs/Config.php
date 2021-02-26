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

    const PHPOPENDOCS_CORS_ALLOW_ORIGIN = ['phpopendocs', 'cors', 'allow_origin'];

    const PHPOPENDOCS_ENVIRONMENT = ['phpopendocs', 'env'];

    const PHPOPENDOCS_ASSETS_FORCE_REFRESH = ['phpopendocs', 'assets_force_refresh'];

    const PHPOPENDOCS_COMMIT_SHA = ['phpopendocs', 'sha'];





//    const OSF_ALLOWED_ACCESS_CIDRS = ['phpopendocs', 'allowed_access_cidrs'];

    // This is used for naming the server for external services. e.g.
    // Google authenticator. It should have a unique name per environment
    const PHPOPENDOCS_SERVER_NAME = ['phpopendocs', 'server_name'];


    /**
     * @param string[] $index
     * @return string
     * @throws \Exception
     */
    public static function get(array $index)
    {
        return getConfig($index);
    }

    public static function testValuesArePresent(): void
    {
        $rc = new \ReflectionClass(self::class);
        $constants = $rc->getConstants();

        foreach ($constants as $constant) {
            $value = getConfig($constant);
        }
    }

    public function getCorsAllowOriginForApi(): string
    {
        return $this->get(self::PHPOPENDOCS_CORS_ALLOW_ORIGIN);
    }

    public static function getEnvironment(): string
    {
        return getConfig(self::PHPOPENDOCS_ENVIRONMENT);
    }

    public static function isProductionEnv(): bool
    {
        if (self::getEnvironment() === Config::ENVIRONMENT_LOCAL) {
            return false;
        }

        return true;
    }
}
