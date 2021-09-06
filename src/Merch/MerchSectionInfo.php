<?php

declare(strict_types = 1);

namespace Merch;

use OpenDocs\SectionInfo;

class MerchSectionInfo implements SectionInfo
{
    public function getRoutes()
    {
        // No routes - just php files in app/public/learning
        return [
        ];
    }
}
