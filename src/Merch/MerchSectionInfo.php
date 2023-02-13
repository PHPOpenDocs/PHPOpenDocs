<?php

declare(strict_types = 1);

namespace Merch;

use OpenDocs\ContentLink;
use OpenDocs\CopyrightInfo;
use OpenDocs\SectionInfo;

class MerchSectionInfo implements SectionInfo
{
    /**
     * @return ContentLink[]
     */
    public function getContentLinks(): array
    {
        return [];
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
        // No routes - just php files in app/public/learning
        return [
        ];
    }
}
