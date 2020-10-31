<?php

declare(strict_types = 1);

namespace Osf\Service\LocalStorage\InvoiceLocalStorage;

use Osf\Model\Invoice;

interface InvoiceLocalStorage
{
    public function isFileAvailable(Invoice $invoice);

    public function getFilename(Invoice $invoice): string;
}
