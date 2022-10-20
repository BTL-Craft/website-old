<?php
class TwigFilesLoader
{
    function load_twig_file($path, $filename, $context)
    {
        $loader = new \Twig\Loader\FilesystemLoader($path);
        $twig = new \Twig\Environment($loader, ['autoescape' => false]);
        /* $twig = new \Twig\Environment($loader, ['autoescape' => false]); */

        echo $twig->render($filename, $context);
    }
}
