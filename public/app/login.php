<?php
$config = json_decode(
    file_get_contents(__DIR__."/../../conf.json"),
    true
);






if ($_POST['type'] == 'login') {
    $eml = $_POST['email'];
    $passwd = $_POST['password'];
    $app->login($eml, $passwd);
}


if ($_POST['type'] == 'remember') {
    /* if ($_POST['selected'] == 'true') {
        $_SESSION['remember'] = true;
        echo 1;
    }
    if ($_POST['selected'] == 'false') {
        $_SESSION['remember'] = false;
        echo 1;
    } */
    $app->remember($_POST['selected']);
}