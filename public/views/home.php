<?php
//Cargamos el archivo twig
require_once __DIR__ . '/../../config/twig.php';

// ---- Variables Twig ----
$data = [
    'name' => 'Fernando Díaz',
    'age' => '27',
    'lang' => $lang,
];

// ---- Renderizar plantilla ----
echo $twig->render('home.html', $data);

