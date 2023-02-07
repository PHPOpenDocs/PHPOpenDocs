<?php

declare(strict_types = 1);

namespace Learning;

use OpenDocs\Section;

class LearningSection extends Section
{
    public function __construct()
    {
        parent::__construct(
            '/learning',
            'Learning',
            'So you want/have been forced to learn PHP?',
            new \Learning\LearningSectionInfo()
        );
    }

    public static function create()
    {
        return new self();
    }
}
