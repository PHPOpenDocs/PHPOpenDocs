<?php

declare(strict_types = 1);

namespace RfcCodexOpenDocs;

use OpenDocs\GetRoute;
use OpenDocs\SectionInfo;

class RfcCodexSectionInfo implements SectionInfo
{
    public function getRoutes()
    {
        return [
            new GetRoute('/{name:.+}', 'RfcCodexOpenDocs\Pages::getPage'),
        ];
    }
}
