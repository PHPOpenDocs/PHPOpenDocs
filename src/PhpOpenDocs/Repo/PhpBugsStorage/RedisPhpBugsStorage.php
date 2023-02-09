<?php

declare(strict_types = 1);

namespace PHPOpenDocs\Repo\PhpBugsStorage;

use PHPOpenDocs\Model\PhpBugsMaxComment;
use PHPOpenDocs\Key\PhpBugsMaxCommentStorageKey;
use Redis;

class RedisPhpBugsStorage implements PhpBugsStorage
{
    /** @var Redis */
    private $redis;

    /**
     *
     * @param Redis $redis
     */
    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
    }

    public function clear(): void
    {
        $key = PhpBugsMaxCommentStorageKey::getAbsoluteKeyName();
        $this->redis->del($key);
    }

    public function getPhpBugsMaxComment(): ?PhpBugsMaxComment
    {
        $key = PhpBugsMaxCommentStorageKey::getAbsoluteKeyName();
        $result = $this->redis->get($key);
        if ($result === false) {
            return null;
        }

        $phpBugsMaxCommentData = json_decode_safe($result);
        $result = PhpBugsMaxComment::fromArray($phpBugsMaxCommentData);
        return $result;
    }

    public function storePhpBugsMaxComment(PhpBugsMaxComment $phpBugsMaxComment): void
    {
        $key = PhpBugsMaxCommentStorageKey::getAbsoluteKeyName();
        $dataToStore = convertToValue('john', $phpBugsMaxComment);
        $stringToStore = json_encode($dataToStore);
        $this->redis->set(
            $key,
            $stringToStore
        );
    }

//    public function getProposedMotions()
//    {
//        $externalSource = "https://api.github.com/repos/alwaysseptember/voting/contents/test/data";
//        $key = ProposedMotionStorageKey::getAbsoluteKeyName($externalSource);
//
//        $result = $this->redis->get($key);
//
//        if ($result === null) {
//            // log no data
//            return [];
//        }
//
//        if ($result === false) {
//            // log no data
//            return [];
//        }
//
//        $proposedMotionsData = json_decode_safe($result);
//        $proposedMotions = [];
//        foreach ($proposedMotionsData as $proposedMotionData) {
//            $proposedMotions[] = convertDataToMotion($proposedMotionData);
//        }
//
//        return $proposedMotions;
//    }
//
//    /**
//     * @param string $externalSource
//     * @param ProposedMotion[] $proposedMotions
//     */
//    public function storeProposedMotions(
//        string $externalSource,
//        array $proposedMotions
//    ): void {
//
//        $key = ProposedMotionStorageKey::getAbsoluteKeyName($externalSource);
//        // Tiff - magic happens in convertToValue
//        $dataToStore = convertToValue('john', $proposedMotions);
//
//        $stringToStore = json_encode($dataToStore);
//
//        $this->redis->setex(
//            $key,
//            24 * 3600, // 1 day,
//            $stringToStore
//        );
//    }
}
