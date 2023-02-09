<?php

declare(strict_types = 1);

namespace Sponsoring;

use OpenDocs\GetRoute;
use OpenDocs\SectionInfo;

class SponsoringSectionInfo implements SectionInfo
{
    public function getRoutes()
    {
        return [
//            new GetRoute('/nouns', 'NamingThings\Pages::getNounsPage'),
//            new GetRoute('/verbs', 'NamingThings\Pages::getVerbsPage'),
//            new GetRoute('', 'Work\Pages::getIndexPage'),
        ];
    }
}
