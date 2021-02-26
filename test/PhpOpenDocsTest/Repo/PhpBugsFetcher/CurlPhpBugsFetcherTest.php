<?php

declare(strict_types = 1);

namespace PhpOpenDocsTest\Repo\PhpBugsFetcher;

use PHPUnit\Framework\TestCase;
use PhpOpenDocs\Repo\PhpBugsFetcher\CurlPhpBugsFetcher;

class CurlPhpBugsFetcherTest extends TestCase
{
    public function testGetPhpBugsMaxComment()
    {
        $bugsFetcher = new CurlPhpBugsFetcher();
        $phpBugsMaxComment = $bugsFetcher->getPhpBugsMaxComment();

        $this->assertInstanceOf(
            \PhpOpenDocs\Model\PhpBugsMaxComment::class,
            $phpBugsMaxComment
        );
    }
}
