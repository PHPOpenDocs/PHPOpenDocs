<?php

function getStaticConfigOptions()
{
    $options = [];

// Determine if we can use the 'host.docker.internal' name.
//    $dockerHost = '10.254.254.254';

//// DB connection settings
//    $options['phpopendocs.database'] = [
//        'schema' => 'osf',
//        'host' => $dockerHost,
//        'username' => 'osf',
//        'password' => 'D9cACV8Pue3CvM93',
//    ];

// Redis connection settings
//    $options['phpopendocs.redis'] = [
//        'host' => $dockerHost,
//        'password' => 'ePvDZpYTXzT5N9xAPu24',
//        'port' => 6379
//    ];

//// Cors settings
//    $options['phpopendocs']['cors'] = [
//        'allow_origin' => 'http://local.phpopendocs.com'
//    ];
//
//// Domains. Used for generating links back to the platform, e.g. for stripe
//// auth flow.
//    $options['phpopendocs']['app_domain'] = 'http://local.app.phpopendocs.com';

// What environment we are using
// production - in production
// production in staging
// 'develop' in develop
// local in local
//    $options['phpopendocs']['env'] = 'local';

// Currently the site is locked down as to who can access it.
// Eventually this will be changed to only apply to the super user
// environment.
    $options['phpopendocs.allowed_access_cidrs'] = [
        '86.7.192.0/24',
        '10.0.0.0/8',
        '127.0.0.1/24',
        "172.0.0.0/8",   // docker local networking
        '192.168.0.0/16'
    ];

    return $options;
}


