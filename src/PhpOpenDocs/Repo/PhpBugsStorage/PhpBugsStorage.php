<?php

declare(strict_types = 1);

namespace PhpOpenDocs\Repo\PhpBugsStorage;

use PhpOpenDocs\Model\PhpBugsMaxComment;

interface PhpBugsStorage
{
    public function getPhpBugsMaxComment(): ?PhpBugsMaxComment;

    public function storePhpBugsMaxComment(PhpBugsMaxComment $phpBugsMaxComment): void;
}
