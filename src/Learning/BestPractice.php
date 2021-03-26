<?php

declare(strict_types = 1);

namespace Learning;

class BestPractice
{
    private string $name;

    private string $description;

    private string $file;

    /**
     *
     * @param string $name
     * @param string $description
     * @param string $file
     */
    public function __construct(
        string $name,
        string $description,
        string $file
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->file = $file;
    }


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }
}
