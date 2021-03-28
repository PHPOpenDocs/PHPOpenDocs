<?php

declare(strict_types = 1);

namespace OpenDocs;

use Params\ExtractRule\GetArrayOfTypeOrNull;
use Params\ExtractRule\GetOptionalString;
use Params\ExtractRule\GetString;
use Params\InputParameter;
use Params\ProcessRule\MinLength;
use Params\ProcessRule\MaxLength;
use Params\Create\CreateFromArray;
use Params\ExtractRule\GetArrayOfType;
use Params\InputParameterList;
use Params\ProcessRule\SkipIfNull;

class ContentLink
{
//    use CreateFromArray;

    private ?string $path;

    private string $description;

    private int $level;

    /**
     *
     * @param string|null $path
     * @param string $description
     * @param int $level
     */
    private function __construct(
        ?string $path,
        string $description,
        int $level
    ) {
        $this->path = $path;
        $this->description = $description;
        $this->level = $level;
    }


    public static function level1(?string $path, string $description)
    {
        return new self($path, $description, 1);
    }

    public static function level2(?string $path, string $description)
    {
        return new self($path, $description, 2);
    }

    public static function level3(?string $path, string $description)
    {
        return new self($path, $description, 3);
    }
}
