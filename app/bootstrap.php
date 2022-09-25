<?php
require __DIR__ . '/parse/twig.php';
require_once __DIR__ . '/database/Autoload.php';

$view = new TwigFilesLoader;
$database_app = new DatabaseApp;
$custom_texts = $database_app->load_custom_text();
if (array_key_exists('key', $_GET)) {
    require __DIR__ . '/../app/debug/autoload.php';
    goto end;
}

if (!array_key_exists('url', $_GET)) {

    $startdate = "2022-03-01";
    
    $now = new DateTime();
    $now_ = $now->format("Y-m-d");

    $second = strtotime($now_)-strtotime($startdate);
    $custom_texts['day'] = $second/86400;

    $view->load_twig_file(__DIR__ . '/../assets/view/index.twig', $custom_texts);
    goto end;
}

switch ($_GET['url']) {
    case 'auth':
        $view->load_twig_file(__DIR__ . '/../assets/view/auth.twig', $custom_texts);

        if (array_key_exists('reg', $_COOKIE)) {
            echo '<script>document.getElementById("i").setAttribute("style", "color: #828282; pointer-events: none");</script>';
        }

        break;

    case 'hole':
        require __DIR__ . '/../assets/view/hole.php';
        break;

    case 'anti-ie':
        $view->load_twig_file(__DIR__ . '/../assets/view/anti-ie.twig', $custom_texts);
        break;

    case 'join':
        $view->load_twig_file(__DIR__.'/../assets/view/join.twig', $custom_texts);
        break;

    default:
        if (substr($_GET['url'], 0, 4) == 'help') {
            $url = substr(strchr($_GET['url'], '/'), 1);
            require __DIR__ . '/../assets/view/help.php';
        } else {
            $view->load_twig_file(__DIR__.'/../assets/view/404.twig', $custom_texts);
        }
}



end:
