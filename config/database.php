<?php

return [
    // 默认数据库
    'default' => 'mysql',
    // 各种数据库配置
    'connections' => [
        'mysql' => [
            'driver'      => 'mysql',
            'host'        => envs('DB_HOST','127.0.0.1'),
            'port'        => envs('DB_PORT',3306),
            'database'    => envs('DB_DATABASE'),
            'username'    => envs('DB_USERNAME', 'root'),
            'password'    => envs('DB_PASSWORD', 'root'),
            'unix_socket' => '',
            'charset'     => 'utf8',
            'collation'   => 'utf8_unicode_ci',
            'prefix'      => envs('DB_PREFIX', ''),
            'strict'      => true,
            'engine'      => null,
        ],
    ],
];
