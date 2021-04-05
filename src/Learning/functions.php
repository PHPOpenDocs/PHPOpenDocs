<?php

declare(strict_types = 1);

namespace Learning;

use OpenDocs\EditInfo;
use OpenDocs\ContentLink;
use OpenDocs\CopyrightInfo;

function getLearningContentLinks(): array
{
    return [
        ContentLink::level1(null, "Best practices"),
        ContentLink::level2('/best_practice_exceptions', 'Exceptions'),
        ContentLink::level2('/best_practice_interfaces_for_external_apis', "Interfaces for external apis"),

        ContentLink::level1(null, "Library recommendations"),
        ContentLink::level2('/php_static_analysis_tools', 'Static analysis tools'),


        ContentLink::level1('/debugging', "Debugging"),
        ContentLink::level2('/debugging/xdebug.php', 'Xdebug'),
        ContentLink::level2('/debugging/', 'GDB'),
        ContentLink::level2('/debugging/', 'Strace'),
        ContentLink::level2('/debugging/valgrind.php', 'Valgrind'),
        ContentLink::level2('/debugging/wireshark.php', 'Wireshark'),

        ContentLink::level1(null, "Good docs"),
        ContentLink::level2('/java_exception_antipatterns', "Java exception anti-patterns"),
    ];
}

function createEditInfo(string $description, string $file, ?int $line): EditInfo
{
    $path = normaliseFilePath($file);

    $link = 'https://github.com/PHPOpenDocs/PHPOpenDocs/blob/main/' . $path;

    if ($link !== null) {
        $link .= '#L' . $line;
    }

    return new EditInfo([$description => $link]);
}

function createLearningDefaultCopyrightInfo()
{
    return new CopyrightInfo(
        'PHP OpenDocs',
        'https://github.com/PHPOpenDocs/PHPOpenDocs/blob/main/LICENSE'
    );
}
