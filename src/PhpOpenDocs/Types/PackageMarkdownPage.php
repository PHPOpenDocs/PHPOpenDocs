<?php

declare(strict_types = 1);

namespace PHPOpenDocs\Types;

/**
 * A package that has been composer installed locally, and so the files
 * are available locally.
 */
class PackageMarkdownPage
{
    private function __construct(
        private string $path_to_package,
        private string $package_url,
        //        private string $package_name,
        private string $path,
        private string $default_branch
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
            __DIR__ . "/../../..",
            "https://github.com/PHPOpenDocs/PHPOpenDocs",
            $path,
            'main'
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
        $path = sprintf(
            "%s/blob/%s/%s",
            $this->package_url,
            $this->default_branch,
            $this->path
        );

        return $path;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
}
