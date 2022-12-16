<?php

return [
    'app' => [
        'timezone' => 'Asia/Ho_Chi_Minh',
        'asset_url' => base_path('assets'),
    ],
    'database' => [
        'default' => 'mysql',
        'connections' => [
            'mysql' => [
                'driver' => 'mysql',
                'host' => '127.0.0.1',
                'port' => '3306',
                'unix_socket' => '',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'prefix_indexes' => true,
                'strict' => false,
                'engine' => 'InnoDB ROW_FORMAT=DYNAMIC',
                'options' => extension_loaded('pdo_mysql') ? array_filter([
                    PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
                ]) : [],
            ],
        ],
    ],
    'view' => [
        'paths' => [
            base_path('views'),
        ],
        'compiled' => realpath(storage_path('views')),
    ],
    'session' => [
        'driver' => 'file',
        'lifetime' => 120,
        'files' => storage_path('sessions'),
        'cookie' => 'session',
        'path' => '/',
        'domain' => env('SESSION_DOMAIN', null),
        'secure' => env('SESSION_SECURE_COOKIE'),
    ],
    'filesystems' => [
        'default' => 'local',
        'disks' => [
            'local' => [
                'driver' => 'local',
                'root' => storage_path(),
            ],

            'public' => [
                'driver' => 'local',
                'root' => storage_path('public'),
                'url' => env('APP_URL') . '/storage',
                'visibility' => 'public',
            ],
        ],
    ],
];
