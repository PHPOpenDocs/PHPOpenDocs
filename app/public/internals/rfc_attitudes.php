<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use PhpOpenDocs\Types\PackageMarkdownPage;
use function Internals\createMarkdownPackagePageFnInternals;

$fn = createMarkdownPackagePageFnInternals(
    PackageMarkdownPage::RfcCodex("etiquette/rfc_attitudes.md"),
    'RFC attitudes',
);

showPageResponse($fn);