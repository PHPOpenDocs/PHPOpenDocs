<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use PHPOpenDocs\Types\PackageMarkdownPage;
use function Internals\createGlobalPageInfoForInternals;

createGlobalPageInfoForInternals('Etiquette vs CoC');

$fn = createMarkdownPackagePageFnSectionFree(
    PackageMarkdownPage::RfcCodex("etiquette/etiquette_vs_coc.md")
);

showPageResponse($fn);