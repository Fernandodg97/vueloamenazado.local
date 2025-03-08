<?php

// Inicializar variables
$pajaro = null;
$mensaje = "";

// Obtener el ID del pájaro desde la URL utilizando una expresión regular
$request = strtok($_SERVER['REQUEST_URI'], '?'); // Obtener solo la parte de la ruta sin parámetros
preg_match('/^\/admin\/pajaro\/(\d+)$/', $request, $matches);

// Verificar si encontramos el ID del pájaro
if (isset($matches[1])) {
    $idPajaro = $matches[1];  // El ID del pájaro será el valor capturado
} else {
    http_response_code(404);
    echo "Pájaro no encontrado.";
    exit;
}

// Obtener detalles del pájaro desde la API
try {
    $url = "http://www.vueloamenazado.local/api/pajaros/$idPajaro/detalles";
    $response = file_get_contents($url);
    
    if ($response === FALSE) {
        throw new Exception("Error al obtener detalles del pájaro desde la API.");
    }

    // Decodificar la respuesta JSON
    $pajaroArray = json_decode($response, true);

    // Verificar si la decodificación fue exitosa
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Error al decodificar JSON: " . json_last_error_msg());
    }

    // Verificar si se obtuvieron datos
    if (empty($pajaroArray)) {
        throw new Exception("No se encontraron detalles para el pájaro con ID $idPajaro.");
    }

    // Asignar los datos del pájaro
    $pajaro = $pajaroArray[0];
} catch (Exception $e) {
    $mensaje = "Error: " . $e->getMessage();
}

// Manejo de formulario (Actualizar detalles del pájaro)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $estado_conservacion = $_POST["estado_conservacion"] ?? '';
    $dieta = $_POST["dieta"] ?? '';
    $poblacion_europea = $_POST["poblacion_europea"] ?? '';
    $pluma = $_POST["pluma"] ?? '';
    $longitud = $_POST["longitud"] ?? '';
    $peso = $_POST["peso"] ?? '';
    $envergadura = $_POST["envergadura"] ?? '';
    $habitats = $_POST["habitats"] ?? '';

    $data = json_encode([
        "estado_conservacion" => $estado_conservacion,
        "dieta" => $dieta,
        "poblacion_europea" => $poblacion_europea,
        "pluma" => $pluma,
        "longitud" => $longitud,
        "peso" => $peso,
        "envergadura" => $envergadura,
        "habitats" => $habitats
    ]);

    $context = stream_context_create([
        "http" => [
            "method" => "PATCH",  // Utilizamos PATCH para la actualización
            "header" => "Content-Type: application/json",
            "content" => $data
        ]
    ]);

    $url = "http://www.vueloamenazado.local/api/pajaros/$idPajaro/detalles";

    $response = file_get_contents($url, false, $context);

    if ($response !== false) {
        $mensaje = "Detalles del pájaro actualizados correctamente.";
    } else {
        $mensaje = "Error al actualizar los detalles del pájaro.";
    }

    header("Location: editar_pajaro.php?id=$idPajaro");
    exit;
}

// Manejo de eliminación
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["eliminar"])) {
    $url = "http://www.vueloamenazado.local/api/pajaros/$idPajaro/detalles";
    $context = stream_context_create([
        "http" => [
            "method" => "DELETE"
        ]
    ]);

    $response = file_get_contents($url, false, $context);
    
    if ($response !== false) {
        $mensaje = "Pájaro eliminado correctamente.";
    } else {
        $mensaje = "Error al eliminar el pájaro.";
    }

    header("Location: lista_pajaros.php");
    exit;
}

// Cargar Twig
require_once __DIR__ . '/../../config/twig.php';

// Renderizar la plantilla Twig
echo $twig->render('adminPajaroId.html.twig', [
    'pajaro' => $pajaro,
    'mensaje' => $mensaje
]);
?>
