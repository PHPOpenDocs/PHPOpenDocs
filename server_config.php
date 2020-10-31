<?php

declare(strict_types=1);


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

    'twig.cache' => 'true',
    'twig.debug' => 'false',
];

// Settings for local development.
$local = [
    'varnish.pass_all_requests' => true,
    'varnish.allow_non_ssl' => true,
    'system.build_debug_php_containers' => true,

    'php.display_errors' => 'On',
    'php.opcache.validate_timestamps' => 1,
    'twig.cache' => 'false',
    'twig.debug' => 'true',
];

// Settings for the report generator
// $report_worker = [
//     // The reports generator runs out of memory
//     'php.memory_limit' => getenv('php.memory_limit') ?: '1024M'
// ];


$varnish_debug = [
    'varnish.pass_all_requests' => false
];


