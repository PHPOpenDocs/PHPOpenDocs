<?php

declare(strict_types = 1);

namespace PhpOpenDocs;

use OpenDocs\GetRoute;
use OpenDocs\SectionInfo;

class SystemSectionInfo implements SectionInfo
{
    public function getRoutes()
    {

// best_practice_base_exceptions.md
// best_practice_interfaces_for_external_apis.md
// php_for_people_who_know_how_to_code.md
// recommended_libraries.md

        return [
//            new GetRoute(
//                '/php_for_people_who_know_how_to_code',
//                'Learning\Pages::getPhpForPeopleWhoCanCode'
//            ),
//            new GetRoute(
//                '/java_exception_antipatterns',
//                'Learning\Pages::getJavaAntipatterns'
//            ),
//
//            new GetRoute('', 'Learning\Pages::getIndexPage'),
        ];
    }
}
