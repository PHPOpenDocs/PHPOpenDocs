<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use PHPOpenDocs\Types\PackageMarkdownPage;
use function Internals\createGlobalPageInfoForInternals;

createGlobalPageInfoForInternals('Etiquette rules');

$fn = createMarkdownPackagePageFnSectionFree(
    PackageMarkdownPage::RfcCodex("etiquette/etiquette_rules.md")
);

showPageResponse($fn);