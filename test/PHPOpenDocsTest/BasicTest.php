<?php

declare(strict_types = 1);

namespace PHPOpenDocsTest;

use OpenDocs\ContentLinks;

class BasicTest extends BaseTestCase
{
    public function test1()
    {
        $contentLinksData = ['children' => [
            [
                'path' => "ref.funchand.php",
                'description' => "Function handling Functions",
                'children' => [
                    [
                        'path' => "function.call-user-func-array.php",
                        'description' => "call_​user_​func_​array"
                    ],
                    [
                        'path' => "function.call-user-func.php",
                        'description' => "call_​user_​func",
                    ],
                    [
                        'path' => "function.forward-static-call-array.php",
                        'description' => "forward_​static_​call_​array",
                    ],
                    [
                        'path' => "function.forward-static-call.php",
                        'description' => "forward_​static_​call",
                    ]
                ],
            ],
            [
                'description' => 'Deprecated',
                'children' => [[
                    'path' => "function.create-function.php",
                    'description' => 'create_​function',
                ]],
            ]
        ]
        ];

        $contentLinks = ContentLinks::createFromArray($contentLinksData);

    }

}