<?php
if (file_exists('../../config/hole.json')) {
    $config = json_decode(file_get_contents('../../config/hole.json'),true);
    $id = count($config['text']);
    $config['text'][$id] = $_POST['text'];
    $config['ip'][$id] = getip();
    file_put_contents('../../config/hole.json',json_encode($config, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
    header('Location: /hole');
}
else {
    echo '<p style="color:red;">服务器查询数据失败：关键文件缺失</p>';
}

function getip() 
{
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP") , "unknown")) 
    {
        $ip = getenv("HTTP_CLIENT_IP");
    } 
    else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR") , "unknown")) 
    {
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    } 
    else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR") , "unknown")) 
    {
        $ip = getenv("REMOTE_ADDR");
    } 
    else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) 
    {
        $ip = $_SERVER['REMOTE_ADDR'];
    } 
    else 
    {
        $ip = "unknown";
    }

    return $ip;
}