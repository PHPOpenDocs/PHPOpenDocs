<?php

declare(strict_types = 1);

namespace Internals;

use OpenDocs\GetRoute;
use OpenDocs\SectionInfo;

class InternalsSectionInfo implements SectionInfo
{
    public function getRoutes()
    {
        // No routes - just php files in app/public/learning

        return [
//            new GetRoute('foo', 'Internals\Pages::getIndexPage'),
        ];
    }
}
