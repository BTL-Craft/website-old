<?php

$config = json_decode(file_get_contents(__DIR__."/../../config/main.json"), true); 

if ($config['debug'] == true) {
    switch ($_GET['key']) {
        case '001':
        case '1':
            # code...
            break;

        case '002':
        case '2':
            # code...
            break;

        case '003':
        case '3':
            # code...
            break;

        case '777':
        case 'clear-usr':
            clearAllUsers();
            break;
        
        default:
            # code...
            break;
    }
} else {
    require __DIR__.'/../html/404.php';
}

function clearAllUsers()
{
    require __DIR__.'/../../app/database/Autoload.php';
    $database = new DatabaseApp;
    $database -> clear();
    echo '已清空数据表';
}



