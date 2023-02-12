<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use PHPOpenDocs\Types\PackageMarkdownPage;
use function Internals\createGlobalPageInfoForInternals;

createGlobalPageInfoForInternals('Mailing list etiquette for young\'uns');

$fn = createMarkdownPackagePageFnSectionFree(
    PackageMarkdownPage::RfcCodex("etiquette/mailing_list_for_younguns.md")
);

showPageResponse($fn);