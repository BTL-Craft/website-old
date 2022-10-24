<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Http错误码信息
    |--------------------------------------------------------------------------
    |
    | 这里定义了不同种类的错误的显示信息
    |
    */
    '400'=> [
        'message'     => '400 Bad Request',
        'description' => '客户端请求的语法错误',
    ],

    '403'=> [
        'message'     => '403 Forbidden',
        'description' => '你没有权限访问此内容',
    ],

    '404'=> [
        'message'     => '404 Not Found',
        'description' => '这里什么都没有哦',
    ],

    '414'=> [
        'message'     => '414 URI Too Long',
        'description' => '客户端请求的 URI 过长',
    ],

    '423'=> [
        'message'     => '423 Locked',
        'description' => '正在访问的资源已锁定。',
    ],

    '429'=> [
        'message'     => '429 Too Many Requests',
        'description' => '在给定的时间内发送了太多请求',
    ],

    '500'=> [
        'message'     => '500 Internal Server Error',
        'description' => '服务器内部错误，请报告此问题',
    ],

    '502'=> [
        'message'     => '502 Bad Gateway',
        'description' => '错误的网关',
    ],

    '503'=> [
        'message'     => '503 Service Unavailable',
        'description' => '服务器内部错误：服务器没有准备好处理请求，请稍后再试',
    ],
];