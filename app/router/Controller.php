<?php

namespace App;

require_once __DIR__ . '/../database/Autoload.php';

use App\Database\DatabaseApp;

class Controller
{
    public static function index()
    {
        echo self::render_view(__DIR__ . '/../../assets/view/', 'index.twig', DatabaseApp::load_custom_text());
    }

    public static function auth()
    {
        echo self::render_view(__DIR__ . '/../../assets/view/', 'auth.twig', DatabaseApp::load_custom_text());
    }

    public static function help($filename)
    {
        $Extra = new \ParsedownExtra();
        $filler = DatabaseApp::load_custom_text();
        if ($filename == null) {
            $filler['page'] = $Extra->text(file_get_contents(__DIR__ . '/../../assets/doc/' . 'welcome' . '.md'));
        } elseif (file_exists(__DIR__ . '/../../assets/doc/' . $filename . '.md')) {
            $filler['page'] = $Extra->text(file_get_contents(__DIR__ . '/../../assets/doc/' . $filename . '.md'));
        } else {
            self::throw_404();
            return;
        }
        echo self::render_view(__DIR__ . '/../../assets/view/', 'help.twig', $filler);
    }

    public static function user($rua)
    {
        echo self::render_view(__DIR__ . '/../../assets/view/', '404.twig', DatabaseApp::load_custom_text());
    }

    public static function anti_ie($rua)
    {
        echo self::render_view(__DIR__ . '/../../assets/view/', 'anti-ie.twig', DatabaseApp::load_custom_text());
    }

    public static function throw_404()
    {
        echo self::render_view(__DIR__ . '/../../assets/view/', '404.twig', DatabaseApp::load_custom_text());
    }

    public static function render_view($path, $filename, $context)
    {
        $loader = new \Twig\Loader\FilesystemLoader($path);
        $twig = new \Twig\Environment($loader, ['autoescape' => false]);

        return $twig->render($filename, $context);
    }
}
