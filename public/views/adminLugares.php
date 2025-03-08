<?php

// Inicializar variables
$lugar = null;
$lugares = [];  // Agregar esta variable para almacenar todos los lugares
$mensaje = "";
$avistamientos = [];

// Obtener detalles del lugar y avistamientos desde la API
try {
    // Obtener datos del lugar (uno específico)
    $urlLugar = "http://www.vueloamenazado.local/api/lugares";
    $responseLugar = file_get_contents($urlLugar);

    if ($responseLugar === FALSE) {
        throw new Exception("Error al obtener detalles del lugar.");
    }

    $lugarArray = json_decode($responseLugar, true);
    if (json_last_error() !== JSON_ERROR_NONE || empty($lugarArray)) {
        throw new Exception("Error al procesar datos del lugar.");
    }
    $lugar = $lugarArray[0]; // Tomamos el primer lugar, si lo hay

    // Obtener avistamientos del lugar, si el lugar tiene ID
    if ($lugar) {
        $urlAvistamientos = "http://www.vueloamenazado.local/api/lugares/" . $lugar['id_lugar'] . "/pajaros";
        $responseAvistamientos = file_get_contents($urlAvistamientos);

        if ($responseAvistamientos !== FALSE) {
            $avistamientos = json_decode($responseAvistamientos, true);
        }
    }

    // Obtener todos los lugares
    $urlLugares = "http://www.vueloamenazado.local/api/lugares";
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
    // POST: Crear un nuevo lugar o actualizar un lugar
    $data = json_encode([
        'nombre' => $_POST['nombre'],
        'ubicacion' => $_POST['ubicacion'],
    ]);

    $urlPost = 'http://www.vueloamenazado.local/api/lugares';
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/json',
            'content' => $data
        ]
    ];
    $context = stream_context_create($options);
    $response = file_get_contents($urlPost, false, $context);

    if ($response === FALSE) {
        $mensaje = "Error al crear el lugar.";
    } else {
        $mensaje = "Lugar creado exitosamente.";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
    // PATCH: Actualizar un lugar
    if (isset($_GET['id'])) {
        $data = json_encode([
            'nombre' => $_POST['nombre'],
            'ubicacion' => $_POST['ubicacion'],
        ]);

        $urlPatch = 'http://www.vueloamenazado.local/api/lugares/' . $_GET['id'];
        $options = [
            'http' => [
                'method' => 'PATCH',
                'header' => 'Content-Type: application/json',
                'content' => $data
            ]
        ];
        $context = stream_context_create($options);
        $response = file_get_contents($urlPatch, false, $context);

        if ($response === FALSE) {
            $mensaje = "Error al actualizar el lugar.";
        } else {
            $mensaje = "Lugar actualizado exitosamente.";
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // DELETE: Eliminar un lugar
    if (isset($_GET['id'])) {
        $urlDelete = 'http://www.vueloamenazado.local/api/lugares/' . $_GET['id'];
        $options = [
            'http' => [
                'method' => 'DELETE'
            ]
        ];
        $context = stream_context_create($options);
        $response = file_get_contents($urlDelete, false, $context);

        if ($response === FALSE) {
            $mensaje = "Error al eliminar el lugar.";
        } else {
            $mensaje = "Lugar eliminado exitosamente.";
        }
    }
}

// Cargar Twig
require_once __DIR__ . '/../../config/twig.php';

// Renderizar la plantilla Twig
echo $twig->render('adminLugares.html.twig', [
    'lugares' => $lugares,  // Pasar la lista de lugares
    'mensaje' => $mensaje,
    'avistamientos' => $avistamientos
]);
