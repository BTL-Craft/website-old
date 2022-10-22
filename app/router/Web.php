<?php

namespace App;

require_once __DIR__ . '/../database/Autoload.php';
require_once __DIR__ . '/../parse/markdown.php';
require_once __DIR__ . '/../parse/markdownextra.php';

use App\Database\DatabaseApp;

class Web
{
    public static function index()
    {
        echo self::render_view('index.twig', DatabaseApp::load_custom_text());
    }

    public static function auth()
    {
        echo self::render_view('auth.twig', DatabaseApp::load_custom_text());
    }

    public static function help($filename)
    {
        $Extra = new \ParsedownExtra();
        $filler = DatabaseApp::load_custom_text();
        $filler['url'] = '"' . $filename . '";';
        if ($filename == null) {
            $filler['page'] = $Extra->text(file_get_contents(__DIR__ . '/../../assets/doc/' . 'welcome' . '.md'));
        } elseif (file_exists(__DIR__ . '/../../assets/doc/' . $filename . '.md')) {
            $filler['page'] = $Extra->text(file_get_contents(__DIR__ . '/../../assets/doc/' . $filename . '.md'));
        } else {
            self::throw_http_error('404');
            return;
        }
        echo self::render_view('help.twig', $filler);
    }

    public static function user($rua=null)
    {
        echo self::render_view('user.twig', DatabaseApp::load_custom_text());
    }

    public static function anti_ie()
    {
        echo self::render_view('anti-ie.twig', DatabaseApp::load_custom_text());
    }

    public static function throw_http_error($code)
    {
        $config = include __DIR__ . '/../../config/error.php';
        $context = DatabaseApp::load_custom_text();
        $context['error_message'] = $config[$code]['message'];
        $context['error_description'] = $config[$code]['description'];

        echo self::render_view('error.twig', $context);
    }

    public static function render_view($filename, $context)
    {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../assets/view/');
        $twig = new \Twig\Environment($loader, ['autoescape' => false]);

        return $twig->render($filename, $context);
    }
}
