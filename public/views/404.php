<?php
//Cargamos el archivo twig
require_once __DIR__ . '/../../config/twig.php';

// ---- Renderizar plantilla ----
echo $twig->render('404.html.twig');