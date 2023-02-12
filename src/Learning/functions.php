<?php

declare(strict_types = 1);

namespace Learning;

use Internals\InternalsSection;
use OpenDocs\BreadcrumbsFactory;
use OpenDocs\EditInfo;
use OpenDocs\ContentLink;
use OpenDocs\CopyrightInfo;
use OpenDocs\ExternalMarkdownRenderer\ExternalMarkdownRenderer;
use OpenDocs\GlobalPageInfo;
use OpenDocs\MarkdownRenderer\MarkdownRenderer;
use OpenDocs\Page;
use PHPOpenDocs\Types\PackageMarkdownPage;

use function Internals\createInternalsDefaultCopyrightInfo;
use function Internals\getInternalsContentLinks;
use OpenDocs\MarkdownRenderer\PackageMarkdownRenderer;

function createGlobalPageInfoForLearning(
    string $title,
    CopyrightInfo $copyrightInfo = null
): void {

    $default_copyright = CopyrightInfo::create(
        'PHP OpenDocs',
        'https://github.com/PHPOpenDocs/PHPOpenDocs/blob/main/LICENSE'
    );

    GlobalPageInfo::create(
        contentLinks: getLearningContentLinks(),
        copyrightInfo: $copyrightInfo ?? $default_copyright,
        section: \Learning\LearningSection::create(),
        title: $title,
        current_path: getRequestPath(),
    );

//    GlobalPageInfo::addMarkDownEditInfo("Edit content", $packageMarkdownPage);
//    GlobalPageInfo::addEditInfoFromBacktrace('Edit page', 1);

    GlobalPageInfo::addEditInfoFromBacktrace('Edit page', 1);
}



function getLearningContentLinks(): array
{
    return [
        ContentLink::level1(null, "Best practices"),
        ContentLink::level2('/best_practice_exceptions', 'Exceptions'),
        ContentLink::level2(
            '/best_practice_interfaces_for_external_apis',
            "Interfaces for external apis"
        ),
        ContentLink::level2(
            '/best_practice_shorts',
            "Best practice shorts"
        ),

        ContentLink::level1(null, "Library recommendations"),
        ContentLink::level2('/php_static_analysis_tools', 'Static analysis tools'),

        ContentLink::level1('/debugging', "Debugging"),
        ContentLink::level2('/debugging/xdebug.php', 'Xdebug'),
        ContentLink::level2('/debugging/gdb', 'GDB'),
        ContentLink::level2('/debugging/strace', 'Strace'),
        ContentLink::level2('/debugging/valgrind.php', 'Valgrind'),
        ContentLink::level2('/debugging/wireshark.php', 'Wireshark'),

        ContentLink::level1(null, "Good docs"),
        ContentLink::level2('/java_exception_antipatterns', "Java exception anti-patterns"),
    ];
}

function createLearningDefaultCopyrightInfo(): CopyrightInfo
{
    return CopyrightInfo::create(
        'PHP OpenDocs',
        'https://github.com/PHPOpenDocs/PHPOpenDocs/blob/main/LICENSE'
    );
}
