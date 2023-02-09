<?php

declare(strict_types = 1);

namespace PHPOpenDocs\Repo\PhpBugsFetcher;

use PHPOpenDocs\Model\PhpBugsMaxComment;

class FakePhpBugsFetcher implements PhpBugsFetcher
{
    public function getPhpBugsMaxComment(): PhpBugsMaxComment
    {
        return new PhpBugsMaxComment(3);
    }
}
