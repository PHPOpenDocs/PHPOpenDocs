<?php

declare(strict_types = 1);

namespace PhpOpenDocsTest\Repo\PhpBugsStorage;

use PhpOpenDocs\Model\PhpBugsMaxComment;
use PhpOpenDocs\Repo\PhpBugsStorage\RedisPhpBugsStorage;
use PhpOpenDocsTest\BaseTestCase;

class RedisPhpBugsStorageTest extends BaseTestCase
{
    /**
     * @group wip
     */
    public function testGetPhpBugsMaxComment()
    {
        $redisPhpBugsStorage = $this->make(RedisPhpBugsStorage::class);
        $redisPhpBugsStorage->clear();
        $this->assertNull($redisPhpBugsStorage->getPhpBugsMaxComment());

        $temp = new PhpBugsMaxComment(124);
        $redisPhpBugsStorage->storePhpBugsMaxComment($temp);

        $stored = $redisPhpBugsStorage->getPhpBugsMaxComment();
        $this->assertInstanceOf(
            PhpBugsMaxComment::class,
            $stored
        );

        $this->assertEquals(
            $temp->getMaxCommentId(),
            $stored->getMaxCommentId()
        );
    }
}
