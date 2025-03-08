<?php
// Incluir el archivo de conexión
$pdo = require_once __DIR__ . '/../../config/conectorDatabase.php';

if (!$pdo instanceof PDO) {
    die("Error: No se pudo conectar a la base de datos.");
}

// Inicializar la variable
$pajaros = [];

try {
    // Llamada a la API
    $url = "http://www.vueloamenazado.local/api/pajaros";
    $response = file_get_contents($url);
    
    if ($response === FALSE) {
        throw new Exception("Error al obtener datos de la API");
    }
    
    // Decodificar JSON
    $pajaros = json_decode($response, true);
    
    // Verificar si la decodificación fue exitosa
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Error al decodificar JSON: " . json_last_error_msg());
    }
    
    // Verificar si se obtuvieron datos
    if (empty($pajaros)) {
        error_log("No se encontraron registros en la API.");
    } else {
        error_log("Se encontraron " . count($pajaros) . " registros.");
    }
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
}

//Cargamos el archivo twig
$twig = require_once __DIR__ . '/../../config/twig.php';

if (empty($pajaros)) {
    error_log("No hay datos en la variable \$pajaros.");
} else {
    error_log("Se encontraron " . count($pajaros) . " registros.");
}

$totalPajaros = count($pajaros); // Contar pájaros


// ---- Renderizar plantilla ----
echo $twig->render('home.html.twig', array_merge(['total_pajaros' => $totalPajaros], ['pajaros' => $pajaros]));


