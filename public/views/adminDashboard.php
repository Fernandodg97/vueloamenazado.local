<?php
print_r($_SESSION);

// Inicializar variables
$pajaros = [];  // Variable para almacenar la lista de pájaros obtenidos desde la API
$mensaje = "";  // Variable para almacenar mensajes de éxito o error

// Obtener lista de pájaros
try {
    // Obtener los datos de la API de pájaros
    $pajarosJson = file_get_contents("http://www.vueloamenazado.local/api/pajaros");
    
    // Decodificar el JSON recibido en un array asociativo
    $pajarosArray = json_decode($pajarosJson, true);

    // Comprobar si el resultado es un solo pájaro y convertirlo en array
    if (isset($pajarosArray["id_pajaro"])) {
        // Si es solo un pájaro, ponerlo en un array
        $pajaros = [$pajarosArray]; 
    } elseif (is_array($pajarosArray)) {
        // Si es un array de pájaros, asignarlo a la variable $pajaros
        $pajaros = $pajarosArray;
    }
} catch (Exception $e) {
    // En caso de error, registrar el error y asignar un mensaje
    error_log("Error obteniendo pájaros: " . $e->getMessage());
    $mensaje = "Error al obtener los datos.";
}

// Manejo de formulario (Crear/Actualizar pájaro)
if ($_SERVER["REQUEST_METHOD"] == "POST" || $_SERVER["REQUEST_METHOD"] == "PATCH") {
    // Determinar si el formulario usa POST o PATCH
    $method = $_POST["_method"] ?? "POST";  // Si no se especifica _method, se usa POST
    // Obtener los datos del formulario
    $idPajaro = $_POST["id_pajaro"] ?? null; // Obtener el id del pájaro si se está actualizando
    $nombre = $_POST["nombre"] ?? '';  // Nombre del pájaro
    $nombre_cientifico = $_POST["nombre_cientifico"] ?? '';  // Nombre científico
    $grupo = $_POST["grupo"] ?? '';  // Grupo del pájaro
    $imagen = $_POST["imagen"] ?? '';  // URL de la imagen
    $como_identificar = $_POST["como_identificar"] ?? '';  // Descripción de cómo identificar al pájaro
    $canto_audio = $_POST["canto_audio"] ?? '';  // URL del audio del canto

    var_dump($_POST); // Verificar que todos los datos del formulario se están enviando correctamente

    // Convertir los datos en un formato JSON para enviarlos a la API
    $data = json_encode([
        "nombre" => $nombre,
        "nombre_cientifico" => $nombre_cientifico,
        "grupo" => $grupo,
        "imagen" => $imagen,
        "como_identificar" => $como_identificar,
        "canto_audio" => $canto_audio
    ]);

    // Crear el contexto para la solicitud HTTP
    $context = stream_context_create([
        "http" => [
            "method" => $method,  // Usar POST o PATCH según corresponda
            "header" => "Content-Type: application/json",  // Especificar que el contenido es JSON
            "content" => $data  // Los datos del formulario en formato JSON
        ]
    ]);

    // Definir la URL de la API dependiendo si estamos creando o actualizando
    $url = $idPajaro
        ? "http://www.vueloamenazado.local/api/pajaros/$idPajaro"  // Si hay id, actualizamos
        : "http://www.vueloamenazado.local/api/pajaros";  // Si no, creamos un nuevo pájaro

    // Realizar la solicitud HTTP
    $response = file_get_contents($url, false, $context);

    // Verificar si la solicitud fue exitosa
    if ($response !== false) {
        // Si es un id, significa que estamos actualizando el pájaro, de lo contrario estamos creando uno nuevo
        $mensaje = $idPajaro ? "Pájaro actualizado correctamente." : "Pájaro agregado correctamente.";
    } else {
        // Si la respuesta es falsa, hubo un error al procesar la solicitud
        $mensaje = "Error al procesar la solicitud.";
    }

    // Redirigir a la página de administración después de procesar el formulario
    header("Location: /admin");
    exit;  // Finalizar la ejecución después de la redirección
}

// Manejo de eliminación
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["eliminar"])) {
    // Obtener el id del pájaro a eliminar desde la URL
    $idEliminar = $_GET["eliminar"];
    // Definir la URL de la API para eliminar el pájaro
    $url = "http://www.vueloamenazado.local/api/pajaros/$idEliminar";
    // Crear el contexto para la solicitud DELETE
    $context = stream_context_create([
        "http" => [
            "method" => "DELETE"  // Método HTTP para eliminar
        ]
    ]);

    // Realizar la solicitud DELETE
    $response = file_get_contents($url, false, $context);
    
    // Verificar si la solicitud fue exitosa
    if ($response !== false) {
        $mensaje = "Pájaro eliminado correctamente.";
    } else {
        $mensaje = "Error al eliminar el pájaro.";
    }

    // Redirigir a la página de administración después de eliminar el pájaro
    header("Location: /admin");
    exit;  // Finalizar la ejecución después de la redirección
}

// Cargar Twig
require_once __DIR__ . '/../../config/twig.php';  // Incluir la configuración de Twig (motor de plantillas)

// Renderizar la plantilla Twig con los datos obtenidos
echo $twig->render('adminDashboard.html.twig', [
    'pajaros' => $pajaros,  // Pasar la lista de pájaros a la plantilla
    'mensaje' => $mensaje   // Pasar el mensaje a la plantilla
]);
?>
