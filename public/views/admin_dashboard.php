<?php
// Obtener el nombre de usuario de la sesión
$username = $_SESSION['username'] ?? 'Usuario';

//Cargamos el archivo twig
require_once __DIR__ . '/../../config/twig.php';

// ---- Renderizar plantilla ----
echo $twig->render('admin_dashboard.html');

