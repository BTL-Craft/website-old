<?php
require __DIR__ . '/Controller.php';

$Router = new \Bramus\Router\Router;
use \App\Controller;

$Router->get('', function() {Controller::index();});
$Router->get('/auth', function() {Controller::auth();});
$Router->get('/help/{rua}', function($rua) {Controller::help($rua);});
$Router->get('/help', function() {Controller::help(null);});
$Router->get('/user/{rua}', function($rua) {Controller::user($rua);});
$Router->get('/user', function() {Controller::user(null);});
$Router->get('/anti-ie', function() {Controller::anti_ie(null);});

$Router->set404(function() {
    header('HTTP/1.1 404 Not Found');
    Controller::throw_404();
});

$Router->run();