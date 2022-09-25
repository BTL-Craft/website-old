<?php
class TwigFilesLoader
{
    function load_twig_file($dir, $context)
    {
        $loader = new \Twig\Loader\ArrayLoader([
            'index' => file_get_contents($dir),
        ]);

        $twig = new \Twig\Environment($loader);

        echo $twig->render('index', $context);
    }
}
