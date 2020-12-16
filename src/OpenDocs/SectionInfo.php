<?php

declare(strict_types = 1);

namespace OpenDocs;

interface SectionInfo
{
    /** @return GetRoute[] */
    public function getRoutes();
}
