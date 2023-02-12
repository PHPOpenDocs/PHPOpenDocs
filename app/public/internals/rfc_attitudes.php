<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use PHPOpenDocs\Types\PackageMarkdownPage;
use function Internals\createGlobalPageInfoForInternals;

createGlobalPageInfoForInternals('RFC attitudes');

$fn = createMarkdownPackagePageFnSectionFree(
    PackageMarkdownPage::RfcCodex("etiquette/rfc_attitudes.md")
);

showPageResponse($fn);