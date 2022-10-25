<?php
require __DIR__ . '/Web.php';
require __DIR__ . '/Api.php';
require_once __DIR__ . '/../database/Autoload.php';

$Router = new \Bramus\Router\Router;

use \App\Web;
use \App\Api;

/* 启动会话 */
ini_set('session.serialize_handler', 'php_serialize');
$config = json_decode(
    file_get_contents(__DIR__ . "/../../.env.json"),
    true
);
session_name($config['session']['session_name']);
session_save_path(__DIR__.'/../../data/session');
session_start();

/* 设置路由 */
$Router->get('', function () {
    Web::index();
});
$Router->get('/auth', function () {
    Web::auth();
});
$Router->get('/auth', function () {
    Web::auth();
});
$Router->get('/auth/{rua}', function ($rua) {
    Web::auth($rua);
});
$Router->get('/help', function () {
    Web::help(null);
});
$Router->get('/help/{rua}', function ($rua) {
    Web::help($rua);
});
$Router->get('/user/{rua}', function ($rua) {
    Web::user($rua);
});
$Router->get('/user', function () {
    Web::user(null);
});
$Router->get('/anti-ie', function () {
    Web::anti_ie(null);
});

$Router->post('', function () {
    switch ($_POST['source']) {
        case 'user_center':
            Web::user($_POST);
            break;
        
        case 'auth':
            Api::auth($_POST);
            break;
        default:
            Api::throw_http_error('404');
            break;
    }
});

$Router->set404(function () {
    Web::throw_http_error('404');
});

$Router->run();
