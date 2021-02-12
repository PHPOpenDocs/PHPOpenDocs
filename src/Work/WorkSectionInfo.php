<?php

declare(strict_types = 1);

namespace Work;

use OpenDocs\GetRoute;
use OpenDocs\SectionInfo;

class WorkSectionInfo implements SectionInfo
{
    public function getRoutes()
    {
        return [
//            new GetRoute('/nouns', 'NamingThings\Pages::getNounsPage'),
//            new GetRoute('/verbs', 'NamingThings\Pages::getVerbsPage'),
            new GetRoute('', 'Work\Pages::getIndexPage'),
        ];
    }
}
