<?php

namespace App\session;
use \env;

class SessionManager  {
    public static function session_start()
    {
        $config = env::load_class('session');
        if ($config['session_file_path'] == "") {
            env::update('session', 'session_file_path', __DIR__ . '/../../data/session');
        }
        if (array_key_exists($config['session_name'],$_COOKIE)) {

        }
    }
}