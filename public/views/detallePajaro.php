<?php
//print_r($_SESSION);

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

// Consultar detalles del pájaro (llamadas directas al controlador, sin HTTP contra el propio servidor)
try {
    $pajaro = PajaroController::getPajaroId($idPajaro, PajaroController::OBJECT);

    if (is_array($pajaro)) {
        $datosArray = DatosController::getDatosIdPajaro($idPajaro, DatosController::OBJECT);
        $datos = is_array($datosArray) ? ($datosArray[0] ?? null) : null;

        $avistamientosIds = AvistamientosController::getAvistamientosId($idPajaro, AvistamientosController::OBJECT);

        $avistamientos = [];
        if (is_array($avistamientosIds)) {
            foreach ($avistamientosIds as $avistamiento) {
                if (isset($avistamiento['id_lugar'])) {
                    $idLugar = $avistamiento['id_lugar'];
                    $lugar = LugaresController::getLugaresId($idLugar, LugaresController::OBJECT);
                    if (is_array($lugar)) {
                        $avistamientos[] = $lugar;
                    }
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
