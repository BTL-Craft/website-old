<?php
require __DIR__ . '/Web.php';
require __DIR__ . '/Api.php';

$Router = new \Bramus\Router\Router;

use \App\Web;
use \App\Api;

$Router->get('', function () {
    Web::index();
});
$Router->get('/auth', function () {
    Web::auth();
});
$Router->get('/help/{rua}', function ($rua) {
    Web::help($rua);
});
$Router->get('/help', function () {
    Web::help(null);
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
            Api::auth();
            break;
        default:
            Web::throw_http_error('404');
            break;
    }
});

$Router->set404(function () {
    Web::throw_http_error('404');
});

$Router->run();
