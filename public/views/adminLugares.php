<?php
// URL base interna para llamadas a la API (mismo contenedor)
$apiBaseUrl = 'http://localhost:' . (getenv('PORT') ?: '80');
$jwt = $_SESSION['jwt'] ?? $_COOKIE['jwt'] ?? null;

// Inicializar variables
$lugar = null;
$lugares = [];
$mensaje = "";
$avistamientos = [];

// Obtener detalles del lugar y avistamientos desde la API
try {
    $urlLugar = $apiBaseUrl . "/api/lugares";
    $responseLugar = file_get_contents($urlLugar);

    if ($responseLugar === FALSE) {
        throw new Exception("Error al obtener detalles del lugar.");
    }

    $lugarArray = json_decode($responseLugar, true);
    if (json_last_error() !== JSON_ERROR_NONE || empty($lugarArray)) {
        throw new Exception("Error al procesar datos del lugar.");
    }
    $lugar = $lugarArray[0];

    if ($lugar) {
        $urlAvistamientos = $apiBaseUrl . "/api/lugares/" . $lugar['id_lugar'] . "/pajaros";
        $responseAvistamientos = file_get_contents($urlAvistamientos);

        if ($responseAvistamientos !== FALSE) {
            $avistamientos = json_decode($responseAvistamientos, true);
        }
    }

    $urlLugares = $apiBaseUrl . "/api/lugares";
    $responseLugares = file_get_contents($urlLugares);

    if ($responseLugares === FALSE) {
        throw new Exception("Error al obtener la lista de lugares.");
    }

    $lugares = json_decode($responseLugares, true);
    if (json_last_error() !== JSON_ERROR_NONE || empty($lugares)) {
        throw new Exception("Error al procesar la lista de lugares.");
    }

} catch (Exception $e) {
    $mensaje = "Error: " . $e->getMessage();
}

// Procesar solicitudes POST, PATCH y DELETE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['_method'])) {
        if ($_POST['_method'] === 'PATCH' && isset($_POST['id'])) {
            $id = $_POST['id'];
            $data = json_encode([
                'nombre' => $_POST['nombre'],
                'ubicacion' => $_POST['ubicacion'],
            ]);

            $urlPatch = $apiBaseUrl . '/api/lugares/' . $id;
            $options = [
                'http' => [
                    'method' => 'PATCH',
                    'header' => "Content-Type: application/json\r\nAuthorization: Bearer " . ($jwt ?? ''),
                    'content' => $data,
                ]
            ];
            $context = stream_context_create($options);
            $response = file_get_contents($urlPatch, false, $context);

            $mensaje = $response === FALSE ? "Error al actualizar el lugar." : "Lugar actualizado exitosamente.";

            header("Location:/admin/lugares");
            exit();
        } elseif ($_POST['_method'] === 'DELETE' && isset($_POST['id'])) {
            $id = $_POST['id'];

            $urlDelete = $apiBaseUrl . '/api/lugares/' . $id;
            $options = [
                'http' => [
                    'method' => 'DELETE', 'header' => 'Authorization: Bearer ' . ($_SESSION['jwt'] ?? ''),
                ]
            ];
            $context = stream_context_create($options);
            $response = file_get_contents($urlDelete, false, $context);

            $mensaje = $response === FALSE ? "Error al eliminar el lugar." : "Lugar eliminado exitosamente.";

            header("Location:/admin/lugares");
            exit();
        }
    } else {
        $data = json_encode([
            'nombre' => $_POST['nombre'],
            'ubicacion' => $_POST['ubicacion'],
        ]);

        $urlPost = $apiBaseUrl . '/api/lugares';
        $options = [
            'http' => [
                'method' => 'POST',
                'header' => "Content-Type: application/json\r\nAuthorization: Bearer " . ($jwt ?? ''),
                'content' => $data,
            ]
        ];
        $context = stream_context_create($options);
        $response = file_get_contents($urlPost, false, $context);

        $mensaje = $response === FALSE ? "Error al crear el lugar." : "Lugar creado exitosamente.";

        header("Location:/admin/lugares");
        exit();
    }
}

// Cargar Twig
require_once __DIR__ . '/../../config/twig.php';

// Renderizar la plantilla Twig
echo $twig->render('adminLugares.html.twig', [
    'lugares' => $lugares,
    'mensaje' => $mensaje,
    'avistamientos' => $avistamientos
]);
