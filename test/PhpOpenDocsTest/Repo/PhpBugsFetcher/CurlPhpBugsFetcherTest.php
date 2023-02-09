<?php

declare(strict_types = 1);

namespace PHPOpenDocsTest\Repo\PhpBugsFetcher;

use PHPUnit\Framework\TestCase;
use PHPOpenDocs\Repo\PhpBugsFetcher\CurlPhpBugsFetcher;

/**
 * @coversNothing
 */
class CurlPhpBugsFetcherTest extends TestCase
{
    public function testGetPhpBugsMaxComment()
    {
        $bugsFetcher = new CurlPhpBugsFetcher();
        $phpBugsMaxComment = $bugsFetcher->getPhpBugsMaxComment();

        $this->assertInstanceOf(
            \PHPOpenDocs\Model\PhpBugsMaxComment::class,
            $phpBugsMaxComment
        );
    }
}
