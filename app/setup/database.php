<?php
require_once __DIR__.'/../database/Autoload.php';

$database = new Execute;

echo '创建表usr...'.'<br>';
$result = $database->execute_command(file_get_contents(__DIR__.'/sql/usr.sql'), null);
if (gettype($result) == 'integer') {
    if ($result == -1) {
        echo '添加表usr失败：数据库错误。请检查日志文件';
        exit();
    }
} 

echo '创建表options...'.'<br>';
$result = $database->execute_command(file_get_contents(__DIR__.'/sql/options.sql'), null);
if (gettype($result) == 'integer') {
    if ($result == -1) {
        echo '添加表usr失败：数据库错误。请检查日志文件';
        exit();
    }
} 

