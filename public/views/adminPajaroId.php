<?php

// Inicializar variables
$pajaro = null;
$mensaje = "";
$avistamientos = [];

// Obtener el ID del pájaro desde la URL utilizando una expresión regular
$request = strtok($_SERVER['REQUEST_URI'], '?'); // Obtener solo la parte de la ruta sin parámetros
preg_match('/^\/admin\/pajaros\/(\d+)$/', $request, $matches);

// Verificar si encontramos el ID del pájaro
if (isset($matches[1])) {
    $idPajaro = $matches[1];  // El ID del pájaro será el valor capturado
} else {
    http_response_code(404);
    echo "Pájaro no encontrado.";
    exit;
}

// Obtener detalles del pájaro y avistamientos desde la API
try {
    // Obtener datos del pájaro
    $urlPajaro = "http://www.vueloamenazado.local/api/pajaros/$idPajaro/detalles";
    $responsePajaro = file_get_contents($urlPajaro);

    if ($responsePajaro === FALSE) {
        throw new Exception("Error al obtener detalles del pájaro.");
    }

    $pajaroArray = json_decode($responsePajaro, true);
    if (json_last_error() !== JSON_ERROR_NONE || empty($pajaroArray)) {
        throw new Exception("Error al procesar datos del pájaro.");
    }
    $pajaro = $pajaroArray[0];

    // Obtener avistamientos del pájaro
    $urlAvistamientos = "http://www.vueloamenazado.local/api/pajaros/$idPajaro/avistamientos";
    $responseAvistamientos = file_get_contents($urlAvistamientos);

    if ($responseAvistamientos !== FALSE) {
        $avistamientos = json_decode($responseAvistamientos, true);
    }
} catch (Exception $e) {
    $mensaje = "Error: " . $e->getMessage();
}

// Manejo de formulario (Actualizar detalles del pájaro)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["actualizar_pajaro"])) {
    $data = json_encode([
        "estado_conservacion" => $_POST["estado_conservacion"] ?? '',
        "dieta" => $_POST["dieta"] ?? '',
        "poblacion_europea" => $_POST["poblacion_europea"] ?? '',
        "pluma" => $_POST["pluma"] ?? '',
        "longitud" => $_POST["longitud"] ?? '',
        "peso" => $_POST["peso"] ?? '',
        "envergadura" => $_POST["envergadura"] ?? '',
        "habitats" => $_POST["habitats"] ?? ''
    ]);

    $context = stream_context_create([
        "http" => [
            "method" => "PATCH",
            "header" => "Content-Type: application/json",
            "content" => $data
        ]
    ]);

    $response = file_get_contents($urlPajaro, false, $context);

    $mensaje = $response !== false ? "Detalles actualizados correctamente." : "Error al actualizar detalles.";
}

// Manejo de avistamientos (Agregar / Editar / Eliminar)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["actualizar_avistamientos"])) {
    $nuevoAvistamiento = $_POST["nuevo_avistamiento"] ?? null;
    $eliminarAvistamiento = $_POST["eliminar_avistamiento"] ?? null;

    // Agregar un nuevo avistamiento
    if (!empty($nuevoAvistamiento)) {
        $data = json_encode(["id_lugar" => $nuevoAvistamiento]);
        $context = stream_context_create([
            "http" => [
                "method" => "POST",
                "header" => "Content-Type: application/json",
                "content" => $data
            ]
        ]);

        $urlAgregarAvistamiento = "http://www.vueloamenazado.local/api/pajaros/$idPajaro/avistamientos";
        $response = file_get_contents($urlAgregarAvistamiento, false, $context);

        $mensaje = $response !== false ? "Avistamiento agregado correctamente." : "Error al agregar avistamiento.";
    }

    // Eliminar un avistamiento existente
    if (!empty($eliminarAvistamiento)) {
        $urlEliminarAvistamiento = "http://www.vueloamenazado.local/api/pajaros/$idPajaro/avistamientos/$eliminarAvistamiento";
        $context = stream_context_create([
            "http" => [
                "method" => "DELETE"
            ]
        ]);

        $response = file_get_contents($urlEliminarAvistamiento, false, $context);
        $mensaje = $response !== false ? "Avistamiento eliminado correctamente." : "Error al eliminar avistamiento.";
    }
}

// Manejo de eliminación del pájaro
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["eliminar"])) {
    $context = stream_context_create([
        "http" => [
            "method" => "DELETE"
        ]
    ]);

    $response = file_get_contents($urlPajaro, false, $context);
    
    if ($response !== false) {
        header("Location: lista_pajaros.php");
        exit;
    } else {
        $mensaje = "Error al eliminar el pájaro.";
    }
}

// Cargar Twig
require_once __DIR__ . '/../../config/twig.php';

// Renderizar la plantilla Twig
echo $twig->render('adminPajaroId.html.twig', [
    'pajaro' => $pajaro,
    'mensaje' => $mensaje,
    'avistamientos' => $avistamientos
]);
?>
