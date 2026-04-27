<?php

use Illuminate\Support\Str;

return [

    'default' => env('DB_CONNECTION', 'mysql'),

    'connections' => [

        'sqlite' => [
            'driver'                  => 'sqlite',
            'url'                     => env('DATABASE_URL'),
            'database'                => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix'                  => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        /*
        |----------------------------------------------------------------------
        | Primary MySQL — read/write split + connection pooling
        |
        | Write queries hit DB_HOST (primary/master).
        | Read queries are distributed across DB_HOST_READ_* replicas.
        | Set DB_HOST_READ_1 = DB_HOST to disable replica and use primary only.
        |
        | sticky = true  → a write in the same request is immediately readable
        |                   without waiting for replication lag.
        |----------------------------------------------------------------------
        */
        'mysql' => [
            'driver'    => 'mysql',
            'url'       => env('DATABASE_URL'),

            'read' => [
                'host' => array_filter([
                    env('DB_HOST_READ_1', env('DB_HOST', '127.0.0.1')),
                    env('DB_HOST_READ_2'),
                    env('DB_HOST_READ_3'),
                ]),
            ],

            'write' => [
                'host' => [env('DB_HOST', '127.0.0.1')],
            ],

            'sticky'    => true,

            'port'      => env('DB_PORT', '3306'),
            'database'  => env('DB_DATABASE', 'forge'),
            'username'  => env('DB_USERNAME', 'forge'),
            'password'  => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix'    => '',
            'prefix_indexes' => true,
            'strict'    => false,
            'engine'    => null,
            'options'   => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA          => env('MYSQL_ATTR_SSL_CA'),
                PDO::ATTR_PERSISTENT            => env('DB_PERSISTENT', false),
                PDO::ATTR_EMULATE_PREPARES      => false,
                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
            ]) : [],
        ],

        /*
        |----------------------------------------------------------------------
        | Secondary connection (kpfi shard / secondary database)
        | Used for read-heavy or isolated operations via ->on('kpfi').
        |----------------------------------------------------------------------
        */
        'kpfi' => [
            'driver'    => 'mysql',
            'url'       => env('DATABASE_URL_2'),

            'read' => [
                'host' => array_filter([
                    env('DB_HOST_2_READ', env('DB_HOST_2', '127.0.0.1')),
                ]),
            ],

            'write' => [
                'host' => [env('DB_HOST_2', '127.0.0.1')],
            ],

            'sticky'    => true,

            'port'      => env('DB_PORT_2', '3306'),
            'database'  => env('DB_DATABASE_2', 'forge'),
            'username'  => env('DB_USERNAME_2', 'forge'),
            'password'  => env('DB_PASSWORD_2', ''),
            'unix_socket' => env('DB_SOCKET_2', ''),
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix'    => '',
            'prefix_indexes' => true,
            'strict'    => false,
            'engine'    => null,
            'options'   => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
                PDO::ATTR_PERSISTENT   => env('DB_PERSISTENT', false),
            ]) : [],
        ],

        'pgsql' => [
            'driver'   => 'pgsql',
            'url'      => env('DATABASE_URL'),
            'host'     => env('DB_HOST', '127.0.0.1'),
            'port'     => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset'  => 'utf8',
            'prefix'   => '',
            'prefix_indexes' => true,
            'schema'   => 'public',
            'sslmode'  => 'prefer',
        ],

    ],

    /*
    |----------------------------------------------------------------------
    | Sharding configuration
    |
    | count = number of extra shards (0 = no sharding, use default only)
    | size  = approximate max rows per shard before spilling to next shard
    |
    | Add shard connections as mysql_shard1, mysql_shard2, etc.
    | They follow the same read/write split structure as 'mysql' above.
    |----------------------------------------------------------------------
    */
    'sharding' => [
        'count' => (int) env('DB_SHARD_COUNT', 0),
        'size'  => (int) env('DB_SHARD_SIZE', 100_000),
    ],

    'migrations' => 'migrations',

    'redis' => [

        'client' => env('REDIS_CLIENT', 'predis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix'  => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_') . '_database_'),
        ],

        'default' => [
            'url'      => env('REDIS_URL'),
            'host'     => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD'),
            'port'     => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url'      => env('REDIS_URL'),
            'host'     => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD'),
            'port'     => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

        'queue' => [
            'url'      => env('REDIS_URL'),
            'host'     => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD'),
            'port'     => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_QUEUE_DB', '2'),
        ],

        'session' => [
            'url'      => env('REDIS_URL'),
            'host'     => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD'),
            'port'     => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_SESSION_DB', '3'),
        ],

    ],

];
