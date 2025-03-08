<?php

// Inicializar variables
$pajaros = [];
$mensaje = "";

// Obtener lista de pájaros
try {
    $pajarosJson = file_get_contents("http://www.vueloamenazado.local/api/pajaros");
    $pajarosArray = json_decode($pajarosJson, true);

    // Convertir el objeto devuelto en un array si no lo es
    if (isset($pajarosArray["id_pajaro"])) {
        $pajaros = [$pajarosArray]; // Convertir en array de pájaros si solo hay uno
    } elseif (is_array($pajarosArray)) {
        $pajaros = $pajarosArray;
    }
} catch (Exception $e) {
    error_log("Error obteniendo pájaros: " . $e->getMessage());
    $mensaje = "Error al obtener los datos.";
}

// Manejo de formulario (Crear/Actualizar pájaro)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idPajaro = $_POST["id"] ?? null;
    $nombre = $_POST["nombre"] ?? '';
    $nombre_cientifico = $_POST["nombre_cientifico"] ?? '';
    $grupo = $_POST["grupo"] ?? '';
    $imagen = $_POST["imagen"] ?? '';
    $como_identificar = $_POST["como_identificar"] ?? '';
    $canto_audio = $_POST["canto_audio"] ?? '';

    $data = json_encode([
        "nombre" => $nombre,
        "nombre_cientifico" => $nombre_cientifico,
        "grupo" => $grupo,
        "imagen" => $imagen,
        "como_identificar" => $como_identificar,
        "canto_audio" => $canto_audio
    ]);

    $context = stream_context_create([
        "http" => [
            "method" => $idPajaro ? "PUT" : "POST",
            "header" => "Content-Type: application/json",
            "content" => $data
        ]
    ]);

    $url = $idPajaro
        ? "http://www.vueloamenazado.local/api/pajaros/$idPajaro"
        : "http://www.vueloamenazado.local/api/pajaros";

    $response = file_get_contents($url, false, $context);

    if ($response !== false) {
        $mensaje = $idPajaro ? "Pájaro actualizado correctamente." : "Pájaro agregado correctamente.";
    } else {
        $mensaje = "Error al procesar la solicitud.";
    }

    header("Location: admin_pajaros.php");
    exit;
}

// Manejo de eliminación
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["eliminar"])) {
    $idEliminar = $_GET["eliminar"];
    $url = "http://www.vueloamenazado.local/api/pajaros/$idEliminar";
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

    header("Location: admin_pajaros.php");
    exit;
}

// Cargar Twig
require_once __DIR__ . '/../../config/twig.php';

// Renderizar la plantilla Twig
echo $twig->render('adminDashboard.html.twig', [
    'pajaros' => $pajaros,
    'mensaje' => $mensaje
]);
?>
