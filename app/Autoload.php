<?php

/**
 * 一个非常好用的自动加载函数，递归加载所有php文件
 */
function requireDir($dir)
{
    $handle = opendir($dir);
    while (false !== ($file = readdir($handle))) {
        if ($file != '.' && $file != '..') {
            $filepath = $dir . '/' . $file;
            if (filetype($filepath) == 'dir') {
                requireDir($filepath);
            } else {
                require_once $filepath;
            }
        }
    }
}


requireDir(__DIR__);
