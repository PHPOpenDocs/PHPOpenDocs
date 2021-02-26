<?php

declare(strict_types = 1);

namespace PhpOpenDocs\Repo\PhpBugsStorage;

use PhpOpenDocs\Model\PhpBugsMaxComment;

class FakePhpBugsStorage implements PhpBugsStorage
{
    private ?PhpBugsMaxComment $phpBugsMaxComment = null;

    public function getPhpBugsMaxComment(): ?PhpBugsMaxComment
    {
        return $this->phpBugsMaxComment;
    }

    public function storePhpBugsMaxComment(PhpBugsMaxComment $phpBugsMaxComment): void
    {
        $this->phpBugsMaxComment = $phpBugsMaxComment;
    }
}
