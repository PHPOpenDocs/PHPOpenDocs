<?php

declare(strict_types = 1);

namespace PhpOpenDocs\Repo\PhpBugsFetcher;

use PhpOpenDocs\Model\PhpBugsMaxComment;

interface PhpBugsFetcher
{
    public function getPhpBugsMaxComment(): PhpBugsMaxComment;
}
