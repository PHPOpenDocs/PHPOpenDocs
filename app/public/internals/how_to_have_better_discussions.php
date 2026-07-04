<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use PHPOpenDocs\Types\PackageMarkdownPage;
use function Internals\createGlobalPageInfoForInternals;

createGlobalPageInfoForInternals('How to have better discussions');

$fn = createMarkdownPackagePageFnSectionFree(
    PackageMarkdownPage::RfcCodex("etiquette/how_to_have_better_discussions.md")
);

showPageResponse($fn);