<?php

declare(strict_types = 1);

namespace PhpOpenDocs\CSPViolation;

use PhpOpenDocs\CSPViolation\CSPViolationReporter;
use PhpOpenDocs\Data\ContentPolicyViolationReport;

interface CSPViolationStorage extends CSPViolationReporter
{
    /** Empty all the reports */
    public function clearReports();

    /**
     * @return ContentPolicyViolationReport[]
     */
    public function getReports();

    public function getCount() : int;
}
