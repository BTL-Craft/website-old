<?php
require_once __DIR__.'/../parse/twig.php';
$view = new TwigFilesLoader;
$custom_texts = array();
$view->load_twig_file(__DIR__ . '/../../assets/view/setup.twig', $custom_texts);