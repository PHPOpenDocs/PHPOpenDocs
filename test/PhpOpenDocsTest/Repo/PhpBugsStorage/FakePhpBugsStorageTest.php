<?php

declare(strict_types = 1);

namespace PHPOpenDocsTest\Repo\PhpBugsStorage;

use PHPOpenDocs\Model\PhpBugsMaxComment;
use PHPOpenDocs\Repo\PhpBugsStorage\FakePhpBugsStorage;
use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
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
