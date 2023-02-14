<?php

declare(strict_types = 1);

namespace PHPOpenDocs\CliController;

use function LoopingExec\continuallyExecuteCallable;

class AliveCheck
{
    /**
     * This is a placeholder background task
     */
    public function run(): void
    {
        $callable = function () {
            $this->runInternal();
        };

        continuallyExecuteCallable(
            $callable,
            $maxRunTime = 600,
            $millisecondsBetweenRuns = 5 * 1000
        );
    }

    public function runInternal(): void
    {
        echo "Alive check is alive at " . date('Y_m_d_H_i_s') . "\n";
        sleep(1);
    }
}
