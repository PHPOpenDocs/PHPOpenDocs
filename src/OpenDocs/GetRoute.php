<?php

declare(strict_types = 1);

namespace OpenDocs;

class GetRoute
{
    /** @var string Fastroute compatible path. This will have the section path in front of it. */
    private string $path;

    /**
     * @var callable or instance method that will be called.
     */
    private $callable;

    /**
     *
     * @param string $path
     * @param $callable callable or instance method
     */
    public function __construct(
        string $path,
        $callable
    ) {
        $this->path = $path;
        $this->callable = $callable;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return callable or instance method
     */
    public function getCallable()
    {
        return $this->callable;
    }

    public function getMethod(): string
    {
        return "GET";
    }
}
