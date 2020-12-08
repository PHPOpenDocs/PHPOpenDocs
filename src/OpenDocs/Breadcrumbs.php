<?php

declare(strict_types = 1);

namespace OpenDocs;

class Breadcrumbs
{
    /** @var Breadcrumb[] */
    private array $breadcrumbs;

    public function __construct(Breadcrumb ...$breadcrumbs)
    {
        $this->breadcrumbs = $breadcrumbs;
    }

    /**
     * @return Breadcrumb[]
     */
    public function getBreadcrumbs(): array
    {
        return $this->breadcrumbs;
    }
}
