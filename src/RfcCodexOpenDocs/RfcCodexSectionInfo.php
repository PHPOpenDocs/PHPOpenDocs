<?php

declare(strict_types = 1);

namespace RfcCodexOpenDocs;

use OpenDocs\ContentLink;
use OpenDocs\CopyrightInfo;
use OpenDocs\GetRoute;
use OpenDocs\SectionInfo;

class RfcCodexSectionInfo implements SectionInfo
{

    /**
     * @return ContentLink[]
     */
    public function getContentLinks(): array
    {
        return getRfcCodexContentLinks();
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
            new GetRoute('/{name:.+}', 'RfcCodexOpenDocs\Pages::getPage'),
        ];
    }
}
