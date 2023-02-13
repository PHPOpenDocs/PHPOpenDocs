<?php

declare(strict_types = 1);

namespace PHPFunding;

use OpenDocs\CopyrightInfo;
use OpenDocs\GetRoute;
use OpenDocs\SectionInfo;

class PHPFundingSectionInfo implements SectionInfo
{
    public function getContentLinks(): array
    {
        throw new \Exception("Not implemented");
    }

    public function getDefaultCopyrightInfo(): CopyrightInfo
    {
        throw new \Exception("Not implemented.");
    }

    public function getRoutes()
    {
        return [
            //new GetRoute('/rfcs', 'PHPFunding\Pages::getRfcPage'),
            new GetRoute('/internals', 'PHPFunding\Pages::getInternalsPage'),
            new GetRoute('/extensions', 'PHPFunding\Pages::getExtensionPage'),
            new GetRoute('/userland', 'PHPFunding\Pages::getUserlandPage'),
            new GetRoute('/', 'PHPFunding\Pages::getIndexPage'),
            new GetRoute('', 'PHPFunding\Pages::getIndexPage'),
        ];
    }
}
