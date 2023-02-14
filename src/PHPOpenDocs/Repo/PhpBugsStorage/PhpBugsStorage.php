<?php

declare(strict_types = 1);

namespace PHPOpenDocs\Repo\PhpBugsStorage;

use PHPOpenDocs\Model\PhpBugsMaxComment;

interface PhpBugsStorage
{
    public function getPhpBugsMaxComment(): ?PhpBugsMaxComment;

    public function storePhpBugsMaxComment(PhpBugsMaxComment $phpBugsMaxComment): void;
}
