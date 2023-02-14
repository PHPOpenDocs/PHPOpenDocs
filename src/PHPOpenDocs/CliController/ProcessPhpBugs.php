<?php

declare(strict_types = 1);

namespace PHPOpenDocs\CliController;

use PHPOpenDocs\Repo\PhpBugsStorage\PhpBugsStorage;
use PHPOpenDocs\Repo\PhpBugsFetcher\PhpBugsFetcher;
use function LoopingExec\continuallyExecuteCallable;

class ProcessPhpBugs
{
    private PhpBugsFetcher $phpBugsFetcher;


    private PhpBugsStorage $phpBugsStorage;

    /**
     *
     * @param PhpBugsFetcher $phpBugsFetcher
     * @param PhpBugsStorage $phpBugsStorage
     */
    public function __construct(
        PhpBugsFetcher $phpBugsFetcher,
        PhpBugsStorage $phpBugsStorage
    ) {
        $this->phpBugsFetcher = $phpBugsFetcher;
        $this->phpBugsStorage = $phpBugsStorage;
    }


    public function updateMaxCommentId(): void
    {
        $callable = function () {
            $this->updateMaxCommentIdInternal();
        };

        continuallyExecuteCallable(
            $callable,
            $maxRunTime = 600,
            $millisecondsBetweenRuns = 10 * 1000
        );
    }

    public function updateMaxCommentIdInternal(): void
    {
        echo "updateMaxCommentIdInternal \n";

        $maxComment = $this->phpBugsFetcher->getPhpBugsMaxComment();
        $this->phpBugsStorage->storePhpBugsMaxComment($maxComment);
        echo "new max is: " . $maxComment->getMaxCommentId() . "\n";
    }
}
