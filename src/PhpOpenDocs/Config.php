<?php

declare(strict_types = 1);

namespace PHPOpenDocs;

class Config
{

//    const EXAMPLE_DATABASE_INFO = 'phpopendocs.database';

    const PHPOPENDOCS_REDIS_INFO = 'phpopendocs.redis';

//    const EXAMPLE_EXCEPTION_LOGGING = ['phpopendocs', 'exception_logging'];

//    const PHPOPENDOCS_CORS_ALLOW_ORIGIN = 'phpopendocs.cors.allow_origin';

    const PHPOPENDOCS_ENVIRONMENT = 'phpopendocs.env';

    const PHPOPENDOCS_ASSETS_FORCE_REFRESH = 'phpopendocs.assets_force_refresh';

    const PHPOPENDOCS_COMMIT_SHA = 'phpopendocs.sha';


//    const OSF_ALLOWED_ACCESS_CIDRS = ['phpopendocs', 'allowed_access_cidrs'];

    // This is used for naming the server for external services. e.g.
    // Google authenticator. It should have a unique name per environment
    // const PHPOPENDOCS_SERVER_NAME = 'phpopendocs.server_name';

    /**
     * @param $key
     * @return mixed
     * @throws \Exception
     */
    public static function get(string $key)
    {
        static $values = null;
        if ($values === null) {
            $values = getGeneratedConfig();
        }

        if (array_key_exists($key, $values) == false) {
            throw new \Exception("No value for " . $key);
        }

        return $values[$key];
    }

    public static function testValuesArePresent(): void
    {
        $rc = new \ReflectionClass(self::class);
        $constants = $rc->getConstants();

        foreach ($constants as $constant) {
            $value = self::get($constant);
        }
    }

//    public function getCorsAllowOriginForApi(): string
//    {
//        return self::get(self::PHPOPENDOCS_CORS_ALLOW_ORIGIN);
//    }

    public static function getVersion(): string
    {
        return self::get(self::PHPOPENDOCS_ENVIRONMENT) . "_" . self::get(self::PHPOPENDOCS_COMMIT_SHA);
    }

    public static function getEnvironment(): string
    {
        return self::get(self::PHPOPENDOCS_ENVIRONMENT);
    }

    public function getForceAssetRefresh(): bool
    {
        return $this->get(self::PHPOPENDOCS_ASSETS_FORCE_REFRESH);
    }

    public function getCommitSha(): string
    {
        return $this->get(self::PHPOPENDOCS_COMMIT_SHA);
    }

    public static function isProductionEnv(): bool
    {
        if (self::getEnvironment() === App::ENVIRONMENT_LOCAL) {
            return false;
        }

        return true;
    }
}
