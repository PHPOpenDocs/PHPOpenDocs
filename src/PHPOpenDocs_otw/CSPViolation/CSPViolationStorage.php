<?php

declare(strict_types = 1);

namespace PHPOpenDocs\CSPViolation;

use PHPOpenDocs\Data\ContentPolicyViolationReport;

interface CSPViolationStorage extends CSPViolationReporter
{
    /** Empty all the reports */
    public function clearReports(): void;

    /**
     * @return ContentPolicyViolationReport[]
     */
    public function getReports();

    public function getCount() : int;
}
