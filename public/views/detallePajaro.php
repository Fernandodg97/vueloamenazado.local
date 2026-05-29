<?php
//print_r($_SESSION);

// URL base interna para llamadas a la API (mismo contenedor)
$apiBaseUrl = 'http://localhost:' . (getenv('PORT') ?: '80');

// Obtener el ID del pájaro desde la URL utilizando una expresión regular
$request = strtok($_SERVER['REQUEST_URI'], '?');
preg_match('/^\/pajaros\/(\d+)$/', $request, $matches);

// Verificar si encontramos el ID del pájaro
if (isset($matches[1])) {
    $idPajaro = $matches[1];
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
    $pajaroJson = file_get_contents($apiBaseUrl . "/api/pajaros/$idPajaro");
    $pajaro = json_decode($pajaroJson, true);

    if ($pajaro) {
        $datosJson = file_get_contents($apiBaseUrl . "/api/pajaros/$idPajaro/datos");
        $datosArray = json_decode($datosJson, true);
        $datos = $datosArray[0] ?? null;

        $avistamientosJson = file_get_contents($apiBaseUrl . "/api/pajaros/$idPajaro/avistamientos");
        $avistamientosIds = json_decode($avistamientosJson, true);

        $avistamientos = [];
        foreach ($avistamientosIds as $avistamiento) {
            if (isset($avistamiento['id_lugar'])) {
                $idLugar = $avistamiento['id_lugar'];
                $lugarJson = file_get_contents($apiBaseUrl . "/api/lugares/$idLugar");
                $lugar = json_decode($lugarJson, true);
                if ($lugar) {
                    $avistamientos[] = $lugar;
                }
            }
        }
    } else {
        http_response_code(404);
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
