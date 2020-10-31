<?php

declare(strict_types = 1);

namespace PhpOpenDocs\CSPViolation;

use PhpOpenDocs\Data\ContentPolicyViolationReport;

class FakeCSPViolationStorage implements CSPViolationStorage
{
    /** @var int  */
    private $clearCalls = 0;

    /** @var ContentPolicyViolationReport[]  */
    private $reports = [];

    public function clearReports()
    {
        $this->clearCalls += 1;
    }

    public function getReports()
    {
        return $this->reports;
    }

    public function report(ContentPolicyViolationReport $cpvr)
    {
        $this->reports[] = $cpvr;
    }


    public function getCount(): int
    {
        return count($this->reports);
    }

    /**
     * @return int
     */
    public function getClearCalls(): int
    {
        return $this->clearCalls;
    }
}
