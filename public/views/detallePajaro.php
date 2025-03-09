<?php
// Incluir el archivo de conexión
$pdo = require_once __DIR__ . '/../../config/conectorDatabase.php';

// Obtener el ID del pájaro desde la URL utilizando una expresión regular
$request = strtok($_SERVER['REQUEST_URI'], '?'); // Obtener solo la parte de la ruta sin parámetros
preg_match('/^\/pajaros\/(\d+)$/', $request, $matches);

// Verificar si encontramos el ID del pájaro
if (isset($matches[1])) {
    $idPajaro = $matches[1];  // El ID del pájaro será el valor capturado
} else {
    http_response_code(404);
    echo "Pájaro no encontrado.";
    exit;
}

// Inicializar las variables
$pajaro = null;
$datos = null;
$avistamientos = [];

// Consultar detalles del pájaro
try {
    // Obtener datos del pájaro desde la API
    $pajaroJson = file_get_contents("http://www.vueloamenazado.local/api/pajaros/$idPajaro");
    $pajaro = json_decode($pajaroJson, true);

    if ($pajaro) {
        // Obtener detalles adicionales del pájaro
        $datosJson = file_get_contents("http://www.vueloamenazado.local/api/pajaros/$idPajaro/detalles");
        $datosArray = json_decode($datosJson, true);
        $datos = $datosArray[0] ?? null; // Extraer el primer elemento del array si existe

        // Obtener avistamientos del pájaro
        $avistamientosJson = file_get_contents("http://www.vueloamenazado.local/api/pajaros/$idPajaro/avistamientos");
        $avistamientosIds = json_decode($avistamientosJson, true);

        // Obtener detalles de los lugares de avistamiento
        $avistamientos = [];
        foreach ($avistamientosIds as $avistamiento) {
            if (isset($avistamiento['id_lugar'])) {
                $idLugar = $avistamiento['id_lugar'];
                $lugarJson = file_get_contents("http://www.vueloamenazado.local/api/lugares/$idLugar");
                $lugar = json_decode($lugarJson, true);
                if ($lugar) {
                    $avistamientos[] = $lugar;
                }
            }
        }        
    } else {
        // Si no se encuentra el pájaro
        http_response_code(404);
        echo "Pájaro no encontrado.";
        exit;
    }
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
}

// Cargar Twig
require_once __DIR__ . '/../../config/twig.php';

// Renderizar la plantilla Twig
echo $twig->render('detallePajaro.html.twig', [
    'pajaro' => $pajaro,
    'datos' => $datos,
    'avistamientos' => $avistamientos
]);
?>
