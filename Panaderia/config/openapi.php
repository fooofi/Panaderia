<?php

return [
    'collections' => [
        'default' => [
            'info' => [
                'title' => config('app.name'),
                'description' => null,
                'version' => '1.0.0',
            ],

            'servers' => [
                [
                    'url' => env('APP_URL'),
                ],
            ],

            'tags' => [
                // [
                //    'name' => 'user',
                //    'description' => 'Application users',
                // ],
                [
                    'name' => 'fair users',
                    'description' => 'Fair users',
                ],
                [
                    'name' => 'location',
                    'description' => 'Regional location',
                ],
                [
                    'name' => 'search',
                    'description' => 'Search methods',
                ],
                [
                    'name' => 'institutions',
                    'description' => 'Institutions',
                ],
            ],

            'security' => [
                // GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityRequirement::create()->securityScheme('JWT'),
                \GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityRequirement::create()->securityScheme('OAuth'),
            ],

            // Route for exposing specification.
            // Leave uri null to disable.
            'route' => [
                'uri' => '/openapi',
                'middleware' => [],
            ],

            // Register custom middlewares for different objects.
            'middlewares' => [
                'paths' => [
                    //
                ],
            ],
        ],
    ],
];
