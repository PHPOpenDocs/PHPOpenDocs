<?php

declare(strict_types = 1);

namespace PhpOpenDocs\CliController;

use function LoopingExec\continuallyExecuteCallable;

class AliveCheck
{
    /**
     * This is a placeholder background task
     */
    public function run()
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

    public function runInternal()
    {
        echo "Alive check is alive at " . date('Y_m_d_H_i_s') . "\n";
        sleep(1);
    }
}
