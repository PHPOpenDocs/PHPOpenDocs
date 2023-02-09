<?php

declare(strict_types = 1);

namespace OpenDocs\SiteHtml;

use OpenDocs\GetRoute;

interface SectionInfo
{
    /** @return GetRoute[] */
    public function getRoutes();
}
