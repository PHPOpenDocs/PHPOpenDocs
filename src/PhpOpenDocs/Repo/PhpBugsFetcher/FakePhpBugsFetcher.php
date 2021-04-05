<?php

declare(strict_types = 1);

namespace PhpOpenDocs\Repo\PhpBugsFetcher;

use PhpOpenDocs\Model\PhpBugsMaxComment;

class FakePhpBugsFetcher implements PhpBugsFetcher
{
    public function getPhpBugsMaxComment(): PhpBugsMaxComment
    {
        return new PhpBugsMaxComment(3);
    }
}
