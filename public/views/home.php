<?php
// Incluir el archivo de conexión
$pdo = require_once __DIR__ . '/../../config/conectorDatabase.php';

if (!$pdo instanceof PDO) {
    die("Error: No se pudo conectar a la base de datos.");
}

// Inicializar la variable
$pajaros = [];

// Obtener la letra seleccionada desde la URL
$letra = isset($_GET['letra']) ? $_GET['letra'] : '';

try {
    // Llamada a la API
    $url = "http://www.vueloamenazado.local/api/pajaros";
    $response = file_get_contents($url);
    
    if ($response === FALSE) {
        throw new Exception("Error al obtener datos de la API");
    }
    
    // Decodificar JSON
    $pajaros = json_decode($response, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Error al decodificar JSON: " . json_last_error_msg());
    }

    // Filtrar por la letra seleccionada
    if (!empty($letra) && ctype_alpha($letra)) {
        $pajaros = array_filter($pajaros, function($pajaro) use ($letra) {
            return stripos($pajaro['nombre'], $letra) === 0;
        });
    }

} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
}

// Contar los pájaros filtrados
$totalPajaros = count($pajaros);

// Cargar Twig y renderizar la plantilla
$twig = require_once __DIR__ . '/../../config/twig.php';
echo $twig->render('home.html.twig', [
    'total_pajaros' => $totalPajaros,
    'pajaros' => $pajaros,
    'letra_seleccionada' => $letra
]);
