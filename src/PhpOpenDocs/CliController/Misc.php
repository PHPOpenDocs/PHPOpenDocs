<?php

declare(strict_types = 1);

namespace ASVoting\CliController;

class Misc
{
    public function waitForDBToBeWorking($maxTimeToWait = null)
    {
        if ($maxTimeToWait === null) {
            $maxTimeToWait = 60;
        }

        $startTime = microtime(true);

        do {
            try {
                $pdo = createPDO();
                $pdo->query('SELECT 1');
                echo "DB appears to be available.\n";
                return;
            } catch (\Exception $e) {
                echo "DB not available yet: " . $e->getMessage() . "\n";
            }

            sleep(1);
        } while ((microtime(true) - $startTime) < $maxTimeToWait);
    }
}
