<?php
// URL base interna para llamadas a la API (mismo contenedor)
$apiBaseUrl = 'http://localhost:' . (getenv('PORT') ?: '80');

// Inicializar variables
$pajaro = null;
$datos = null;
$mensaje = "";
$avistamientos = [];
$lugares = [];

// Obtener el ID del pájaro desde la URL
$request = strtok($_SERVER['REQUEST_URI'], '?');
preg_match('/^\/admin\/pajaros\/(\d+)$/', $request, $matches);

if (isset($matches[1])) {
    $idPajaro = $matches[1];
} else {
    http_response_code(404);
    echo "Pájaro no encontrado.";
    exit;
}

// Consultar pájaro
try {
    $pajaroJson = file_get_contents($apiBaseUrl . "/api/pajaros/$idPajaro");
    $pajaro = json_decode($pajaroJson, true);
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
}

// Obtener datos del pájaro y avistamientos
try {
    $urlPajaro = $apiBaseUrl . "/api/pajaros/$idPajaro/datos";
    $responsePajaro = file_get_contents($urlPajaro);

    if ($responsePajaro === FALSE) {
        throw new Exception("Error al obtener detalles del pájaro.");
    }

    $pajaroArray = json_decode($responsePajaro, true);
    if (json_last_error() !== JSON_ERROR_NONE || empty($pajaroArray)) {
        throw new Exception("Error al procesar datos del pájaro.");
    }

    if (isset($pajaroArray[0])) {
        $datos = $pajaroArray[0];
        $mensajeError = false;
    } else {
        $mensajeError = ['error' => true, 'idPajaro' => $idPajaro];
    }

    $urlAvistamientos = $apiBaseUrl . "/api/pajaros/$idPajaro/avistamientos";
    $responseAvistamientos = file_get_contents($urlAvistamientos);

    if ($responseAvistamientos !== FALSE) {
        $avistamientosData = json_decode($responseAvistamientos, true);
        if (isset($avistamientosData['status']) && $avistamientosData['status'] === 'error') {
            $avistamientos = null;
        } else {
            $avistamientos = $avistamientosData;
        }
    } else {
        $avistamientos = null;
    }
} catch (Exception $e) {
    $mensaje = "Error: " . $e->getMessage();
}

// Actualizar pájaro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["actualizar_pajaro"])) {
    $data = json_encode([
        "nombre" => $_POST["nombre"] ?? '',
        "nombre_cientifico" => $_POST["nombre_cientifico"] ?? '',
        "grupo" => $_POST["grupo"] ?? '',
        "imagen" => $_POST["imagen"] ?? '',
        "como_identificar" => $_POST["como_identificar"] ?? '',
        "canto_audio" => $_POST["canto_audio"] ?? ''
    ]);

    $context = stream_context_create([
        "http" => [
            "method" => "PATCH",
            "header" => "Content-Type: application/json",
            "content" => $data
        ]
    ]);

    $url = $apiBaseUrl . "/api/pajaros/$idPajaro";
    $response = file_get_contents($url, false, $context);
    $mensaje = $response !== false ? "Pájaro actualizado correctamente." : "Error al procesar la solicitud.";

    header("Location:/admin/pajaros/$idPajaro");
    exit;
}

// Actualizar detalles del pájaro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["actualizar_datos_pajaro"])) {
    $idClave = $_POST["id_clave"] ?? null;
    $method = $idClave ? "PATCH" : "POST";

    $data = json_encode([
        "id_pajaro" => $idPajaro,
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
            "method" => $method,
            "header" => "Content-Type: application/json",
            "content" => $data
        ]
    ]);

    $url = $idClave
        ? $apiBaseUrl . "/api/datos/$idClave"
        : $apiBaseUrl . "/api/datos";

    $response = file_get_contents($url, false, $context);
    $mensaje = $response !== false ? "Detalles guardados correctamente." : "Error al guardar detalles.";

    header("Location:/admin/pajaros/$idPajaro");
    exit();
}

// Agregar avistamiento
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["accion"]) && $_POST["accion"] == "actualizar_avistamientos") {
    $nuevoAvistamiento = $_POST["nuevo_avistamiento"] ?? null;

    if (!empty($nuevoAvistamiento)) {
        $data = json_encode([
            "id_pajaro" => $idPajaro,
            "id_lugar" => $nuevoAvistamiento
        ]);

        $context = stream_context_create([
            "http" => [
                "method" => "POST",
                "header" => "Content-Type: application/json",
                "content" => $data
            ]
        ]);

        $urlAgregarAvistamiento = $apiBaseUrl . "/api/avistamientos";
        $response = @file_get_contents($urlAgregarAvistamiento, false, $context);

        if ($response !== false) {
            $mensaje = "Avistamiento agregado correctamente.";
            header("Location: " . strtok($_SERVER['REQUEST_URI'], '?'));
            exit();
        } else {
            $mensaje = "Error al agregar avistamiento: " . error_get_last()['message'];
        }
    } else {
        $mensaje = "Error: El lugar para el avistamiento no está seleccionado.";
    }
}

// Eliminar avistamiento
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["eliminar"]) && $_GET["eliminar"] === "true") {
    $idLugar = $_GET["id_lugar"] ?? null;

    if (!empty($idPajaro) && !empty($idLugar)) {
        $urlEliminarAvistamiento = $apiBaseUrl . "/api/avistamientos/$idPajaro/$idLugar";
        $context = stream_context_create(["http" => ["method" => "DELETE"]]);
        $response = file_get_contents($urlEliminarAvistamiento, false, $context);
        $mensaje = $response !== false ? "Avistamiento eliminado correctamente." : "Error al eliminar avistamiento.";

        header("Location: " . strtok($_SERVER['REQUEST_URI'], '?'));
        exit();
    } else {
        $mensaje = "Error: Faltan parámetros para eliminar el avistamiento.";
    }
}

// Eliminar datos del pájaro
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["eliminar"])) {
    $idPajaroEliminar = $_GET["id_pajaro"] ?? null;

    if ($idPajaroEliminar) {
        $context = stream_context_create([
            "http" => ["method" => "DELETE", "header" => "Content-Type: application/json"]
        ]);

        $url = $apiBaseUrl . "/api/datos/$idPajaroEliminar";
        $response = file_get_contents($url, false, $context);

        if ($response !== false) {
            header("Location: " . strtok($_SERVER['REQUEST_URI'], '?'));
            exit();
        } else {
            $mensaje = "Error al eliminar el pájaro.";
        }
    } else {
        $mensaje = "ID del pájaro no especificado.";
    }
}

// Obtener todos los lugares
$urlLugares = $apiBaseUrl . "/api/lugares";
$responseLugares = file_get_contents($urlLugares);
if ($responseLugares === FALSE) {
    $lugares = [];
} else {
    $lugares = json_decode($responseLugares, true) ?: [];
}

// Cargar Twig
require_once __DIR__ . '/../../config/twig.php';

// Renderizar la plantilla Twig
echo $twig->render('adminPajaroId.html.twig', [
    'pajaro' => $pajaro,
    'datos' => $datos,
    'mensaje' => $mensaje,
    'avistamientos' => $avistamientos,
    'lugares' => $lugares,
    'idPajaro' => $idPajaro,
    'mensaje_error' => $mensajeError ?? false
]);
