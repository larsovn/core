<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'app' => [
        'timezone' => 'Asia/Ho_Chi_Minh',
        'asset_url' => base_path('assets'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

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

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */

    'view' => [
        'paths' => [
            base_path('views'),
        ],
        'compiled' => realpath(storage_path('views')),
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Session Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default session "driver" that will be used on
    | requests. By default, we will use the lightweight native driver but
    | you may specify any of the other wonderful drivers provided here.
    |
    | Supported: "file", "cookie", "database", "apc",
    |            "memcached", "redis", "dynamodb", "array"
    |
    */

    'session' => [
        'driver' => 'file',
        'lifetime' => 120,
        'files' => storage_path('sessions'),
        'cookie' => 'session',
        'path' => '/',
        'domain' => env('SESSION_DOMAIN', null),
        'secure' => env('SESSION_SECURE_COOKIE'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

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

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'logging' => [
        'default' => 'stack',
        'channels' => [
            'stack' => [
                'driver' => 'stack',
                'channels' => ['single'],
                'ignore_exceptions' => false,
            ],

            'single' => [
                'driver' => 'single',
                'path' => storage_path('logs/laravel.log'),
                'level' => env('LOG_LEVEL', 'debug'),
            ],

            'daily' => [
                'driver' => 'daily',
                'path' => storage_path('logs/laravel.log'),
                'level' => env('LOG_LEVEL', 'debug'),
                'days' => 14,
            ],

            'slack' => [
                'driver' => 'slack',
                'url' => env('LOG_SLACK_WEBHOOK_URL'),
                'username' => 'Laravel Log',
                'emoji' => ':boom:',
                'level' => env('LOG_LEVEL', 'critical'),
            ],

            'papertrail' => [
                'driver' => 'monolog',
                'level' => env('LOG_LEVEL', 'debug'),
                'handler' => SyslogUdpHandler::class,
                'handler_with' => [
                    'host' => env('PAPERTRAIL_URL'),
                    'port' => env('PAPERTRAIL_PORT'),
                ],
            ],

            'stderr' => [
                'driver' => 'monolog',
                'level' => env('LOG_LEVEL', 'debug'),
                'handler' => StreamHandler::class,
                'formatter' => env('LOG_STDERR_FORMATTER'),
                'with' => [
                    'stream' => 'php://stderr',
                ],
            ],

            'syslog' => [
                'driver' => 'syslog',
                'level' => env('LOG_LEVEL', 'debug'),
            ],

            'errorlog' => [
                'driver' => 'errorlog',
                'level' => env('LOG_LEVEL', 'debug'),
            ],

            'null' => [
                'driver' => 'monolog',
                'handler' => NullHandler::class,
            ],

            'emergency' => [
                'path' => storage_path('logs/laravel.log'),
            ],
        ],
    ],
];
