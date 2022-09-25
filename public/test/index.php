<?php
require __DIR__.'/../../app/database/Autoload.php';
$a = new DatabaseApp;

$data = $a->load_options();
var_dump($data);
echo $data[0]['value'];