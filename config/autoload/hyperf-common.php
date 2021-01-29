<?php
declare(strict_types=1);

return [
    'cgw' => [
        'force_auth' => env('FORCE_AUTH', false),//强制校验签名,开启后CGW协议必须带签名参数访问
        'sign_ttl' => 10,
        'config_list' => [
            "test" => "abcdefg",
        ]
    ],
    'rate_limit' => [
        'access_rate_limit' => 10, //频率限制次数
        'access_rate_ttl' => 20, //频率限制秒，两者组合为每20秒内最多允许10次请求单一接口
        'white_list' => [
            '/weixin'
        ],
    ],
    'cors' => [
        'enable_cross_origin' => env('ENABLE_CROSS_ORIGIN', true),
        'allow_cross_origins' => [
            'http://127.0.0.1',
            'http://localhost',
            'http://lulinggushi.com'
        ],
    ],
    'clear_log' => [
        'days' => 3, // 只保留三天的日志，三天以前的自动清除,设置成-1表示不执行清除任务
    ],
    'mail' => [
        'smtp' => [
            'host' => 'smtp.qq.com',
            'auth' => true,
            'username' => '',//qq邮箱账号,eg. 1003081775@qq.com
            'password' => '',//qq邮箱申请的授权密码
            'port' => '465', //qq邮箱经测试是465端口+ssl协议有效果
            'secure' => 'ssl'
        ]
    ],
];