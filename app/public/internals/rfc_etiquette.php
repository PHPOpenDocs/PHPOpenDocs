<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use PHPOpenDocs\Types\PackageMarkdownPage;
use function Internals\createMarkdownPackagePageFnInternals;

$fn = createMarkdownPackagePageFnInternals(
    PackageMarkdownPage::RfcCodex("etiquette/rfc_etiquette.md"),
    'RFC etiquette',
);

showPageResponse($fn);