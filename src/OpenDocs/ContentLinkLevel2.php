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

class ContentLinkLevel2 implements InputParameterList
{
    use CreateFromArray;

    private ?string $path;

    private string $description;

    /** @var ContentLinkLevel3[]|null */
    private ?array $children;

    /**
     *
     * @param ?string $path
     * @param string $description
     * @param ContentLinkLevel3[]|null $children
     */
    public function __construct(
        ?string $path,
        string $description,
        ?array $children
    ) {
        $this->path = $path;
        $this->description = $description;
        $this->children = $children;
    }


    /**
     * @return string
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return ContentLinkLevel3[]|null
     */
    public function getChildren(): ?array
    {
        return $this->children;
    }

    /**
     * @return \Params\InputParameter[]
     */
    public static function getInputParameterList(): array
    {
        return [
            new InputParameter(
                'path',
                new GetOptionalString(),
                new SkipIfNull(),
                new MinLength(2),
                new MaxLength(1024)
            ),

            new InputParameter(
                'description',
                new GetString(),
                new MinLength(2),
                new MaxLength(1024)
            ),

            new InputParameter(
                'children',
                new GetArrayOfTypeOrNull(ContentLinkLevel3::class),
            ),
        ];
    }
}
