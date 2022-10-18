<?php
function Logging($errinfo)
{
    $errlog = '[' . date("H:i:s") .'] [MySQL/ERROR]: '. $errinfo . "\n";
    @fwrite(fopen('../../log/'.date("Y-m-d").'.log', 'a'), $errlog);
    echo '服务器内部错误，请报告此问题';
}
