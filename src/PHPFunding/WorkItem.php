<?php

declare(strict_types = 1);


namespace PHPFunding;


interface WorkItem
{
    public function getDescription(): string;
    public function getUrl(): string;
}