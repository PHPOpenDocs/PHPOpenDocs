<?php

declare(strict_types = 1);

namespace PHPOpenDocs;

use OpenDocs\ContentLink;
use OpenDocs\CopyrightInfo;
use OpenDocs\SectionInfo;

class SystemSectionInfo implements SectionInfo
{
    /**
     * @return ContentLink[]
     */
    public function getContentLinks(): array
    {
        return [
            ContentLink::level1(null, "Sytem"),
            ContentLink::level2('/', 'System info'),
            ContentLink::level2('/csp_violations', 'CSP violations'),
            ContentLink::level2('/exception_test', 'Exception test'),
            ContentLink::level2('/brain_dump', 'Brain dump'),
        ];
    }

    public function getDefaultCopyrightInfo(): CopyrightInfo
    {
        return CopyrightInfo::create(
            'PHP OpenDocs',
            'https://github.com/Danack/RfcCodex/blob/master/LICENSE'
        );
    }

    public function getRoutes()
    {
        return [
//            new GetRoute(
//                '/java_exception_antipatterns',
//                'Learning\Pages::getJavaAntipatterns'
//            ),
//
//            new GetRoute('', 'Learning\Pages::getIndexPage'),
        ];
    }
}
