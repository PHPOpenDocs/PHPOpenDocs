<?php

declare(strict_types = 1);

namespace PhpOpenDocsTest\Repo\PhpBugsStorage;

use PhpOpenDocs\Model\PhpBugsMaxComment;
use PhpOpenDocs\Repo\PhpBugsStorage\FakePhpBugsStorage;
use PHPUnit\Framework\TestCase;

class FakePhpBugsStorageTest extends TestCase
{

    public function testGetPhpBugsMaxComment()
    {
        $foo = new FakePhpBugsStorage();

        $this->assertNull($foo->getPhpBugsMaxComment());

        $temp = new PhpBugsMaxComment(123);
        $foo->storePhpBugsMaxComment($temp);

        $this->assertSame(
            $temp,
            $foo->getPhpBugsMaxComment()
        );
    }
}
