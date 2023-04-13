<?php

declare(strict_types = 1);

require_once __DIR__ . "/../vendor/autoload.php";

require_once __DIR__ . "/../src/functions.php";

use SiteChecker\SiteChecker;

$base_domain = 'http://local.phpopendocs.com';
$errors = [];

$excluded_urls = [
    '/system/exception_test'
];

$siteChecker = new SiteChecker(
    'http://local.phpopendocs.com',
    '/',
    $excluded_urls
);

$siteChecker->run();

$errors = $siteChecker->getErrors();

if (count($errors) > 0) {
    echo "Checked " . $siteChecker->numberOfPagesChecked() . " pages.\n";
    echo "There were " . count($errors) . " errors:\n";
    foreach ($errors as $error) {
        printf(
            "Url: %s, status: %s, message %s - linked from %s\n",
            $error->getUrl(),
            $error->getStatus(),
            $error->getErrorMessage(),
            $error->getOriginUrl()
        );
    }

    exit(-1);
}

echo "Checked " . $siteChecker->numberOfPagesChecked() . " pages without errors.\n";

// $siteChecker->dumpPagesChecked();
