<?php

declare(strict_types = 1);

namespace Internals;

use OpenDocs\CopyrightInfo;
use OpenDocs\GlobalPageInfo;

function createGlobalPageInfoForInternals(
    string $title,
    string $html = null,
    CopyrightInfo $copyrightInfo = null
): void {
    $section = \Internals\InternalsSection::create();

    GlobalPageInfo::createFromSection(
        $section,
        $title,
        $html,
        $copyrightInfo
    );
}
