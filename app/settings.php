<?php
return [
    'settings' => [
        'mode' => 'dev',
        'determineRouteBeforeAppMiddleware' => true,
        'displayErrorDetails' => true,
        'timezone' => 'America/Chicago',

        // Twig settings
        'twig' => [
            'path' => __DIR__ . '/templates',
            'options' => [
                'cache' => __DIR__ . '/../var/cache',
                'debug' => true,
            ]
        ],
        
        // SwiftMailer settings
        'swiftmailer' => [
            'transport' => 'mail',
            'options' => [
                'host' => 'localhost',
                'port' => 25,
                'username' => '',
                'password' => '',
            ]
        ],

        // Monolog settings
        'monolog' => [
            'name' => 'monolog',
            'path' => __DIR__ . '/../var/logs/app.log',
        ],
        
        // ORM settings
        'eloquent' => [
            'driver' => 'sqlite',
            'host' => 'localhost',
            'database' => __DIR__ . '/../db/slim_starter.sqlite',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'collation' => 'utf8_general_ci',
            'prefix' => '',
        ],
    ],
];
