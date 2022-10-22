<?php
$config = json_decode(
    file_get_contents(__DIR__."/../../config/main.json"),
    true
);



if (file_exists(__DIR__.'/../../app/database/Autoload.php')) {
    require __DIR__.'/../../app/database/Autoload.php';
    $app = new DatabaseApp;
}
else {
    echo '<script>alert("登录失败：关键文件缺失。\n请及时报告此问题，报告问题时附带上这个窗口的截图。\n错误发生时间："+Date());window.location.replace(".")</script>';
    $errinfo = '[' . date("H:i:s") .'] [login/ERROR]: This file was not found: auth.php' . "\n";
    fwrite(fopen('../../log/'.date("Y-m-d").'.log', 'a'), $errinfo);
}


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