<?php

declare(strict_types = 1);

namespace PHPOpenDocs;

trait FromArray
{
    /**
     * @param array $data
     * @return static
     * @throws \ReflectionException
     */
    public static function fromArray(array $data): self
    {
        $reflection = new \ReflectionClass(__CLASS__);
        $instance = $reflection->newInstanceWithoutConstructor();



        foreach ($instance as $key => &$property) {
            $property = $data[$key];
        }

        return $instance;
    }
}
