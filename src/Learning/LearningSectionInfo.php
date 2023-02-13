<?php

declare(strict_types = 1);

namespace Learning;

use OpenDocs\ContentLink;
use OpenDocs\CopyrightInfo;
use OpenDocs\GetRoute;
use OpenDocs\SectionInfo;

class LearningSectionInfo implements SectionInfo
{
    /**
     * @return ContentLink[]
     */
    public function getContentLinks(): array
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
            ContentLink::level2(
                '/unit_testing_tips',
                "Unit testing tips"
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

    public function getDefaultCopyrightInfo(): CopyrightInfo
    {
        return CopyrightInfo::create(
            'PHP OpenDocs',
            'https://github.com/PHPOpenDocs/PHPOpenDocs/blob/main/LICENSE'
        );
    }

    public function getRoutes()
    {
        // No routes - just php files in app/public/learning
        return [
//            new GetRoute(
//                '/java_exception_antipatterns',
//                'Learning\Pages::getJavaAntipatterns'
//            ),

            new GetRoute('', 'Learning\Pages::getIndexPage'),
        ];
    }
}
