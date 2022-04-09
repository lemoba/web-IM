<?php

return [
    // HTTP 请求的超时时间（秒）
    'timeout' => 5.0,

    // 默认发送配置
    'default' => [
        // 网关调用策略，默认：顺序调用
        'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

        // 默认可用的发送网关
        'gateways' => [
            'aliyun',
        ],
    ],
    // 可用的网关配置
    'gateways' => [
        'errorlog' => [
            'file' => '/tmp/easy-sms.log',
        ],
        'aliyun' => [
            'access_key_id' => 'LTAI5tDnMSv8KtA7iMn4zDeX',
            'access_key_secret' => 'lcbXgeEYlO8f2SM4pWlN771izoAQES',
            'sign_name' => '学咖秀',
        ],
        //...
    ],
];