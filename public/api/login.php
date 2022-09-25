<?php
if (file_exists('../../app/auth.php')) {
    require __DIR__.'/../../app/auth.php';
}
else {
    echo '<script>alert("登录失败：关键文件缺失。\n请及时报告此问题，报告问题时附带上这个窗口的截图。\n错误发生时间："+Date());window.location.replace(".")</script>';
    $errinfo = '[' . date("H:i:s") .'] [login/ERROR]: This file was not found: auth.php' . "\n";
    fwrite(fopen('../../log/'.date("Y-m-d").'.log', 'a'), $errinfo);
}
if (array_key_exists("email", $_POST) && array_key_exists("password", $_POST)) 
{
    $eml = $_POST['email'];
    $passwd = $_POST['password'];
    if (filter_var($eml, 274)) {
        switch (login($eml, $passwd))
        {
            case 0:
                echo '用户不存在';
                break;
            case 1:
                echo '密码错误';
                break;
            case 2:
                echo 'QQ未绑定';
                break;
            case 3:
                $loginfo = '[' . date("H:i:s") .'] [login/INFO]: The user is logged in. '."\n".
                '[' . date("H:i:s") .'] [login/INFO]: Email: '.$eml."\n".
                '[' . date("H:i:s") .'] [login/INFO]: IP: '.getip()."\n";
                fwrite(fopen('../../log/'.date("Y-m-d").'.log', 'a'), $loginfo);
                echo '登录成功';
                break;
        }
    } 
    else 
    {
        exit();
    }
} 
else 
{
    end:
    echo '用户不存在';
}