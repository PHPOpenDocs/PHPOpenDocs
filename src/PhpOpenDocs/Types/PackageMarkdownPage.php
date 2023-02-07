<?php

namespace PhpOpenDocs\Types;

/**
 * A package that has been composer installed locally, and so the files
 * are available locally.
 */
class PackageMarkdownPage
{
    private function __construct(
        private string $path_to_package,
        private string $package_url,
        private string $package_name,
        private string $path
    ) {
    }

    public static function RfcCodex(string $path): self
    {
        return new self(
            __DIR__ . "/../../../vendor/danack/rfc-codex",
            "https://github.com/Danack/RfcCodex",
            'RfcCodex',
            $path
        );
    }

    public static function Learning(string $path): self
    {
        return new self(
            __DIR__ . "/../../../src/Learning",
            "https://github.com/PHPOpenDocs/Learning",
            'Learning',
            $path
        );
    }

    /**
     * @return string
     */
    public function getPackageUrl(): string
    {
        return $this->package_url;
    }

    /**
     * @return string
     */
    public function getPathToPackage(): string
    {
        return $this->path_to_package;
    }




    public function getEditUrl(): string
    {
        return sprintf(
            "https://github.com/Danack/%s/blob/master/%s",
            $this->package_name,
            $this->path
        );
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
}