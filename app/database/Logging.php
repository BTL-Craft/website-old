<?php
function Logging($errinfo)
{
    $errlog = '[' . date("H:i:s") .'] [MySQL/ERROR]: '. $errinfo . "\n";
    @fwrite(fopen('../../log/'.date("Y-m-d").'.log', 'a'), $errlog);
    echo '注册失败：数据库错误。请报告此问题';       
}
