<?php

declare(strict_types = 1);

namespace PhpOpenDocsTest\Repo\PhpBugsFetcher;

use PhpOpenDocs\Repo\PhpBugsFetcher\FakePhpBugsFetcher;
use PHPUnit\Framework\TestCase;

class FakePhpBugsFetcherTest extends TestCase
{

    public function testGetPhpBugsMaxComment()
    {
        $bugsFetcher = new FakePhpBugsFetcher();
        $phpBugsMaxComment = $bugsFetcher->getPhpBugsMaxComment();

        $this->assertInstanceOf(
            \PhpOpenDocs\Model\PhpBugsMaxComment::class,
            $phpBugsMaxComment
        );
    }
}
