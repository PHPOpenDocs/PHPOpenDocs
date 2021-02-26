<?php

declare(strict_types = 1);

namespace PhpOpenDocs\Model;

use PhpOpenDocs\ToArray;
use PhpOpenDocs\FromArray;

class PhpBugsMaxComment
{
    private int $maxCommentId;

    /**
     *
     * @param int $maxCommentId
     */
    public function __construct(int $maxCommentId)
    {
        $this->maxCommentId = $maxCommentId;
    }

    public  function toArray()
    {
        return ['max_comment_id' => $this->maxCommentId];
    }

    public static function fromArray(array $data)
    {
        return new self($data['max_comment_id']);
    }

    /**
     * @return int
     */
    public function getMaxCommentId(): int
    {
        return $this->maxCommentId;
    }
}
