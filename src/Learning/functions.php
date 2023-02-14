<?php

declare(strict_types = 1);

namespace Learning;

use OpenDocs\CopyrightInfo;
use OpenDocs\GlobalPageInfo;

function createGlobalPageInfoForLearning(
    string $title,
    CopyrightInfo $copyrightInfo = null,
    string $html = null,
): void {
    $section = \Learning\LearningSection::create();

    GlobalPageInfo::createFromSection(
        $section,
        $title,
        $html,
        $copyrightInfo
    );
    GlobalPageInfo::setContentHtml($html);
}
