<?php

declare(strict_types = 1);

namespace Learning;

class GoodDoc
{
    private string $name;

    private string $description;

    private string $link;

    /**
     *
     * @param string $name
     * @param string $description
     * @param string $link
     */
    public function __construct(
        string $name,
        string $description,
        string $link
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->link = $link;
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
    public function getLink(): string
    {
        return $this->link;
    }
}
