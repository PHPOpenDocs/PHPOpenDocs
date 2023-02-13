<?php

declare(strict_types = 1);

namespace Sponsoring;

use OpenDocs\CopyrightInfo;
use OpenDocs\GetRoute;
use OpenDocs\SectionInfo;

class SponsoringSectionInfo implements SectionInfo
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
//            new GetRoute('/nouns', 'NamingThings\Pages::getNounsPage'),
//            new GetRoute('/verbs', 'NamingThings\Pages::getVerbsPage'),
//            new GetRoute('', 'Work\Pages::getIndexPage'),
        ];
    }
}
