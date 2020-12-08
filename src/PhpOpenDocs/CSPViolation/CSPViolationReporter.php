<?php

declare(strict_types = 1);

namespace PhpOpenDocs\CSPViolation;

use PhpOpenDocs\Data\ContentPolicyViolationReport;

interface CSPViolationReporter
{
    /** Store a report about a CSP violation */
    public function report(ContentPolicyViolationReport $cpvr): void;
}
