<?php

declare(strict_types = 1);

namespace OpenDocs;

use Params\Create\CreateFromArray;
use Params\ExtractRule\GetArrayOfType;
use Params\InputParameter;

class ContentLinks
{
    use CreateFromArray;

    /** @var ContentLinkLevel1[]  */
    private array $children;

    /**
     *
     * @param ContentLinkLevel1[] $children
     */
    public function __construct(array $children)
    {
        $this->children = $children;
    }

    /**
     * @return \Params\InputParameter[]
     */
    public static function getInputParameterList(): array
    {
        return [
            new InputParameter(
                'children',
                new GetArrayOfType(ContentLinkLevel1::class),
            ),
        ];
    }

    /**
     * @return ContentLinkLevel1[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }
}
