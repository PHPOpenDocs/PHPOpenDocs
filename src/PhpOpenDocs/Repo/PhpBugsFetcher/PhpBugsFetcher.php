<?php

declare(strict_types = 1);

namespace PHPOpenDocs\Repo\PhpBugsFetcher;

use PHPOpenDocs\Model\PhpBugsMaxComment;

interface PhpBugsFetcher
{
    public function getPhpBugsMaxComment(): PhpBugsMaxComment;
}
