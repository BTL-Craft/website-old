<?php

namespace App;

class Api {
    function __construct() {
        $config = include __DIR__.'/../../config/session.php';
        session_name($config['session_name']);
        session_start();
    }
    public static function user()
    {
        $_POST;
    }
    public static function auth()
    {
        echo '登录成功';
    }
}