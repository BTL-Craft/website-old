<?php
if (file_exists('../../conf/hole.json')) {
    $config = json_decode(file_get_contents('../../conf/hole.json'),true);
    $maximum = count($config['text']);
    echo $config['text'][mt_rand(0,$maximum-1)];
}
else {
    echo '<p style="color:red;">服务器查询数据失败：关键文件缺失</p>';
}