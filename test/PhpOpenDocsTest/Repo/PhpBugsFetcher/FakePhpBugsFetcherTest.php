<?php

declare(strict_types = 1);

namespace PHPOpenDocsTest\Repo\PhpBugsFetcher;

use PHPOpenDocs\Repo\PhpBugsFetcher\FakePhpBugsFetcher;
use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
class FakePhpBugsFetcherTest extends TestCase
{
    public function testGetPhpBugsMaxComment()
    {
        $bugsFetcher = new FakePhpBugsFetcher();
        $phpBugsMaxComment = $bugsFetcher->getPhpBugsMaxComment();

        $this->assertInstanceOf(
            \PHPOpenDocs\Model\PhpBugsMaxComment::class,
            $phpBugsMaxComment
        );
    }
}
