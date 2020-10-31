<?php

declare(strict_types = 1);

namespace PhpOpenDocs;

//use PhpOpenDocs\Config\TwigConfig;
//use Osf\Data\StripeConnectData;
use PhpOpenDocs\Data\InternalDomain;

class Config
{
    const ENVIRONMENT_LOCAL = 'local';
    const ENVIRONMENT_PROD = 'prod';

    const EXAMPLE_DATABASE_INFO = ['phpopendocs', 'database'];

    const EXAMPLE_REDIS_INFO = ['phpopendocs', 'redis'];

    const EXAMPLE_TWILIO_INFO = ['phpopendocs', 'twilio'];

    const EXAMPLE_STRIPE_INFO = ['phpopendocs', 'stripe'];



    const STRIPE_PLATFORM_SECRET_KEY = ['phpopendocs', 'stripe_key', 'secret'];

    const STRIPE_WEBHOOK_SECRET = ['phpopendocs', 'stripe_key', 'webhook_secret'];


    /** The base domain for the api e.g. 'http://local.api.opensourcefees.com' */
    const STRIPE_PLATFORM_ADMIN_DOMAIN = ['phpopendocs', 'admin_domain'];

    /** The base domain for the api e.g. 'http://local.api.opensourcefees.com' */
    const STRIPE_PLATFORM_API_DOMAIN = ['phpopendocs', 'api_domain'];

    /** The base domain for the site e.g. 'http://local.app.opensourcefees.com' */
    const STRIPE_PLATFORM_APP_DOMAIN = ['phpopendocs', 'app_domain'];

    /** The base domain for the api e.g. 'http://local.internal.opensourcefees.com' */
    const STRIPE_PLATFORM_INTERNAL_DOMAIN = ['phpopendocs', 'internal_domain'];



    const EXAMPLE_SMS_NOTIFICATION_ENABLED = ['phpopendocs', 'sms_notifications_enabled'];

    const EXAMPLE_MANDRILL_INFO = ['phpopendocs', 'mandrill'];

    const EXAMPLE_EXCEPTION_LOGGING = ['phpopendocs', 'exception_logging'];

    const OSF_CORS_ALLOW_ORIGIN = ['phpopendocs', 'cors', 'allow_origin'];

    const OSF_ENVIRONMENT = ['phpopendocs', 'env'];

    const OSF_ALLOWED_ACCESS_CIDRS = ['phpopendocs', 'allowed_access_cidrs'];

    // This is used for naming the server for external services. e.g.
    // Google authenticator. It should have a unique name per environment
    const OSF_SERVER_NAME = ['phpopendocs', 'server_name'];

    const TWIG_INFO_CACHE = ['twig', 'cache'];
    const TWIG_INFO_DEBUG = ['twig', 'debug'];


    const OSF_STRIPE_TEST_ACCOUNT = ['phpopendocs', 'stripe_test_account'];

    const OSF_COOKIE_DOMAIN_ADMIN = ['phpopendocs', 'admin_cookie_domain'];

//    const OSF_COOKIE_DOMAIN_APP = ['osf', 'app_cookie_domain'];

    const OSF_COOKIE_DOMAIN_ADMINSUPER = ['phpopendocs', 'super_cookie_domain'];

    const SUPERADMIN_USERNAMES_AND_HASHES = ['phpopendocs', 'super_usernames_and_hashes'];


    public static function get($index)
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

    public function getAllowedAccessCidrs()
    {
        return $this->get(self::OSF_ALLOWED_ACCESS_CIDRS);
    }

//    public function getTwigConfig() : TwigConfig
//    {
//        return new TwigConfig(
//            getConfig(self::TWIG_INFO_CACHE),
//            getConfig(self::TWIG_INFO_DEBUG)
//        );
//    }

    public static function isProductionEnv()
    {
        if (self::getEnvironment() === Config::ENVIRONMENT_LOCAL) {
            return false;
        }

        return true;
    }

    public static function useSsl()
    {
        if (self::getEnvironment() !== 'local') {
            return true;
        }
        return false;
    }

    public static function getSuperAdminUsernamesAndHashes()
    {

        return getConfig(self::SUPERADMIN_USERNAMES_AND_HASHES);
    }

    public function getAdminDomain(): string
    {
        return getConfig(self::STRIPE_PLATFORM_ADMIN_DOMAIN);
    }

    public function getAppDomain(): string
    {
        return getConfig(self::STRIPE_PLATFORM_APP_DOMAIN);
    }

    public function getApiDomain(): string
    {
        return getConfig(self::STRIPE_PLATFORM_API_DOMAIN);
    }

    public function getStripeWebhookSecret(): string
    {
        return getConfig(self::STRIPE_PLATFORM_API_DOMAIN);
    }

    public function getInternalDomain(): string
    {
        return getConfig(self::STRIPE_PLATFORM_INTERNAL_DOMAIN);
    }

    public static function getCookieDomainAdmin()
    {
        return getConfig(self::OSF_COOKIE_DOMAIN_ADMIN);
    }

    public static function getCookieDomainAdminSuper()
    {
        return getConfig(self::OSF_COOKIE_DOMAIN_ADMINSUPER);
    }
}
