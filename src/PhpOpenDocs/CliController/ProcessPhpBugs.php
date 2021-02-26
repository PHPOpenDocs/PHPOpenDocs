<?php

declare(strict_types = 1);

namespace PhpOpenDocs\CliController;

use PhpOpenDocs\Repo\PhpBugsStorage\PhpBugsStorage;
use PhpOpenDocs\Repo\PhpBugsFetcher\PhpBugsFetcher;
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


    public function updateMaxCommentId()
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

    public function updateMaxCommentIdInternal()
    {
        echo "updateMaxCommentIdInternal \n";

        $maxComment = $this->phpBugsFetcher->getPhpBugsMaxComment();
        $this->phpBugsStorage->storePhpBugsMaxComment($maxComment);
        echo "new max is: " . $maxComment->getMaxCommentId() . "\n";
    }
}
