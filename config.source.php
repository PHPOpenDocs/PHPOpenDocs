<?php

declare(strict_types=1);

use PhpOpenDocs\Config;

$sha = `git rev-parse HEAD`;

$sha = trim($sha);


// Default settings
$default = [
    'varnish.pass_all_requests' => false,
    'varnish.allow_non_ssl' => false,
    'system.build_debug_php_containers' => false,
    'php.memory_limit' => getenv('php.memory_limit') ?: '64M',
    'php.web.processes' => 20,
    'php.web.memory' => '24M',
    'php.display_errors' => 'Off',

    'php.post_max_size' => '1M',
    'php.opcache.validate_timestamps' => 0,

    Config::PHPOPENDOCS_ASSETS_FORCE_REFRESH => false,
    Config::PHPOPENDOCS_COMMIT_SHA => $sha,
//    'phpopendocs.allowed_access_cidrs' => [
//        '86.7.192.0/24',
//        '10.0.0.0/8',
//        '127.0.0.1/24',
//        "172.0.0.0/8",   // docker local networking
//        '192.168.0.0/16'
//    ]
];

// Settings for local development.
$local = [
    'varnish.pass_all_requests' => true,
    'varnish.allow_non_ssl' => true,
    'system.build_debug_php_containers' => true,

    'php.display_errors' => 'On',
    'php.opcache.validate_timestamps' => 1,

// Redis connection settings
    Config::PHPOPENDOCS_REDIS_INFO => [
//        'host' => $dockerHost,
        'host' => '10.254.254.254',
        'password' => 'ePvDZpYTXzT5N9xAPu24',
        'port' => 6379
    ],


//    const PHPOPENDOCS_CORS_ALLOW_ORIGIN = 'http://local.phpopendocs.com';
    Config::PHPOPENDOCS_ENVIRONMENT => 'local',
    Config::PHPOPENDOCS_ASSETS_FORCE_REFRESH => true,

    // Domains. Used for generating links back to the platform,
    // e.g. for stripe auth flow.
    // $options['phpopendocs']['app_domain'] = 'http://local.app.phpopendocs.com';
];

// Settings for the report generator
// $report_worker = [
//     // The reports generator runs out of memory
//     'php.memory_limit' => getenv('php.memory_limit') ?: '1024M'
// ];

$varnish_debug = [
    'varnish.pass_all_requests' => false
];


