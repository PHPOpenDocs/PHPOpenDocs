<?php

declare(strict_types = 1);

namespace Osf\Service\LocalStorage\InvoiceLocalStorage;

use Osf\Model\Invoice;

class FileInvoiceLocalStorage implements InvoiceLocalStorage
{
    /** @var string */
    private $localStoragePath;

    /**
     * FileInvoiceLocalStorage constructor.
     * @param string $localStoragePath
     */
    public function __construct(string $localStoragePath)
    {
        $this->localStoragePath = $localStoragePath;
    }

    public function isFileAvailable(Invoice $invoice)
    {
        $filename = $this->getFilename($invoice);

        return file_exists($filename);
    }

    public function getFilename(Invoice $invoice): string
    {
        $invoiceFilename = 'invoice_' . $invoice->getId() . '.pdf';

        return $this->localStoragePath . '/' . $invoiceFilename;
    }
}
