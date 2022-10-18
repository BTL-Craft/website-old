<?php
if (file_exists( __DIR__.'/../../app/database/Autoload.php')) {
    require __DIR__.'/../../app/database/Autoload.php';
    $app = new DatabaseApp;
}
else 
{
    echo '<script>alert("注册失败：关键文件缺失。\n请及时报告此问题，报告问题时附带上这个窗口的截图。\n错误发生时间："+Date());window.location.replace(".")</script>';
    $errinfo = '[' . date("H:i:s") .'] [register/ERROR]: The file was not found: auth.php' . "\n";
    fwrite(fopen('../../log/'.date("Y-m-d").'.log', 'a'), $errinfo);
}
if ($_POST['type'] == 'captcha') 
{
    session_start();//启动会话
    $eml = $_SESSION['eml'];
    $code = $_POST['code'];
    $conf = json_decode(file_get_contents('../../conf/auth.json'), true);
    $host = $conf['apihost']; //读配置文件，并提取出python程序的IP地址
    $data = json_decode(@file_get_contents($host));
    $right = false;
    foreach ($data as $key => $value) 
    {
        if ($value[0] == $code && $value[1] > time()) 
        {
            $app->save_qid($eml, $key);
            exit();
        }
    }
    echo '无效的验证码';
    exit();
}
if (!array_key_exists("email", $_POST) || !array_key_exists("password", $_POST) || !array_key_exists("username", $_POST)) 
{
    header('Location: .');
}
$eml = $_POST['email'];
$passwd = $_POST['password'];
$usrname = $_POST['username'];
if (filter_var($eml, 274)) 
{ //验证，通过后开始注册
    if (!preg_match('/[^\w]/', $usrname))
    {
        $ip = getip();
        $reg_time = date("Y-m-d h:i:s");
        $app->register($eml, $passwd, $usrname, $ip, $reg_time, '0', '0');
    } else echo '用户名格式错误';
} 
else 
{
    echo 'Email格式错误'; //不通过则返回
}

function getip()
{

    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) {
        $ip = getenv("HTTP_CLIENT_IP");
    } 
    

    else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) {
        $ip = getenv("HTTP_X_FORWARDED_FOR");

        
    } else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) {
        $ip = getenv("REMOTE_ADDR");

    } else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) {
        $ip = $_SERVER['REMOTE_ADDR'];


    } else {
        $ip = "unknown";
    }

    return $ip;
}