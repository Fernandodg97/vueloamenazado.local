<?php
echo "<br>";
print_r('<b>Datos sesión TEST:</b>');
echo "<br>";
echo "<b>¿Está logueado? </b>" . (SessionController::isLoggedIn() ? "<br>Sí" : "<br>No");
echo "<br>";
print_r('<b>Sesión: </b>');
echo "<br>";
;print_r($_SESSION);
echo "<br>";
print_r('<b>Token en cookie jwt: </b>');echo $_COOKIE['jwt'];
echo "<br>";

// Inicializar variables
$pajaro = null;
$mensaje = "";
$avistamientos = [];
$lugares = [];  // Variable para almacenar todos los lugares

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
    $urlPajaro = "http://www.vueloamenazado.local/api/pajaros/$idPajaro/datos";
    $responsePajaro = file_get_contents($urlPajaro);

    if ($responsePajaro === FALSE) {
        throw new Exception("Error al obtener detalles del pájaro.");
    }

    $pajaroArray = json_decode($responsePajaro, true);
    if (json_last_error() !== JSON_ERROR_NONE || empty($pajaroArray)) {
        throw new Exception("Error al procesar datos del pájaro.");
    }

    if (isset($pajaroArray[0])) {
        $pajaro = $pajaroArray[0];
        $mensajeError = false;  // Si el pájaro se encuentra, asignamos false
    } else {
        $mensajeError = [
            'error' => true,  // Indicamos que hay un error
            'idPajaro' => $idPajaro  // Incluimos el idPajaro
        ];http://www.vueloamenazado.local/api/pajaros/$idPajaro/detalles
    }

    // Obtener avistamientos del pájaro
    $urlAvistamientos = "http://www.vueloamenazado.local/api/pajaros/$idPajaro/avistamientos";
    $responseAvistamientos = file_get_contents($urlAvistamientos);

    if ($responseAvistamientos !== FALSE) {
        $avistamientosData = json_decode($responseAvistamientos, true);
        
        // Verificar si la respuesta contiene un estado de error
        if (isset($avistamientosData['status']) && $avistamientosData['status'] === 'error') {
            $avistamientos = null; // Si hay error, asignar null
        } else {
            $avistamientos = $avistamientosData; // Si no hay error, asignar los datos de los avistamientos        
        }
    }else {
        $avistamientos = null;
    }
} catch (Exception $e) {
    $mensaje = "Error: " . $e->getMessage();
}

// Manejo de formulario (Actualizar detalles del pájaro)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["actualizar_pajaro"])) {
    // Se obtiene el id_clave si existe
    $idClave = $_POST["id_clave"] ?? null;
    
    // Preparar los datos para la solicitud en formato JSON
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

    // Se determina si es PATCH o POST según la existencia de id_clave
    $method = $idClave ? "PATCH" : "POST"; // Si hay id_clave, actualizar (PATCH), si no, crear (POST)

    // Crear el contexto de la solicitud con el método y los datos
    $context = stream_context_create([
        "http" => [
            "method" => $method,
            "header" => "Content-Type: application/json",
            "content" => $data
        ]
    ]);

    // Si es PATCH, se incluye el id_clave en la URL para actualizar, de lo contrario, es un POST
    $url = $idClave ? "http://www.vueloamenazado.local/api/datos/$idClave" : "http://www.vueloamenazado.local/api/datos"; // Si es PATCH, usar el ID en la URL

    // Enviar la solicitud y obtener la respuesta
    $response = file_get_contents($url, false, $context);

    // Mostrar el mensaje de éxito o error
    $mensaje = $response !== false ? "Detalles guardados correctamente." : "Error al guardar detalles.";

    // Redirigir después de crear el lugar
    //header("Location:/admin/pajaros/$idPajaro");
    //exit();

if ($response === false) {
    echo "Error al hacer la solicitud.";
} else {
    echo "Respuesta de la API: " . $response;
}
}

// Manejo de avistamientos - Agregar
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

        $urlAgregarAvistamiento = "http://www.vueloamenazado.local/api/avistamientos";
        
        // Usamos @ para evitar los warnings en caso de error
        $response = @file_get_contents($urlAgregarAvistamiento, false, $context);

        if ($response !== false) {
            $mensaje = "Avistamiento agregado correctamente.";
            header("Location: " . strtok($_SERVER['REQUEST_URI'], '?'));
            exit();
        } else {
            // Enviar el error como mensaje
            $mensaje = "Error al agregar avistamiento: " . error_get_last()['message'];
        }
    } else {
        $mensaje = "Error: El lugar para el avistamiento no está seleccionado.";
    }
}


// Manejo de avistamientos - Eliminar
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["eliminar"]) && $_GET["eliminar"] === "true") {
    $idLugar = $_GET["id_lugar"] ?? null;

    if (!empty($idPajaro) && !empty($idLugar)) {
        $urlEliminarAvistamiento = "http://www.vueloamenazado.local/api/avistamientos/$idPajaro/$idLugar";
        $context = stream_context_create([
            "http" => [
                "method" => "DELETE"
            ]
        ]);

        $response = file_get_contents($urlEliminarAvistamiento, false, $context);
        $mensaje = $response !== false ? "Avistamiento eliminado correctamente." : "Error al eliminar avistamiento.";

        header("Location: " . strtok($_SERVER['REQUEST_URI'], '?'));
        exit();
    } else {
        $mensaje = "Error: Faltan parámetros para eliminar el avistamiento.";
    }
}



// Manejo de eliminación datos del pájaro
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["eliminar"])) {
    // Obtén el ID del pájaro (por ejemplo, desde la URL)
    $idPajaro = $_GET["id_pajaro"] ?? null; // Asume que el ID viene de la URL como parámetro

    if ($idPajaro) {
        // Crear el contexto para la solicitud DELETE
        $context = stream_context_create([
            "http" => [
                "method" => "DELETE",
                "header" => "Content-Type: application/json"
            ]
        ]);

        // Definir la URL con el idPajaro para realizar la eliminación
        $url = "http://www.vueloamenazado.local/api/datos/$idPajaro/$idLugar";

        // Enviar la solicitud DELETE
        $response = file_get_contents($url, false, $context);
        
        if ($response !== false) {
            // Redirigir después de crear el lugar
            header("Location: " . strtok($_SERVER['REQUEST_URI'], '?'));
            exit();
        } else {
            // Si hay error, mostrar el mensaje
            $mensaje = "Error al eliminar el pájaro.";
        }
    } else {
        $mensaje = "ID del pájaro no especificado.";
    }
}

// Obtener todos los lugares
$urlLugares = "http://www.vueloamenazado.local/api/lugares";  // URL para obtener la lista de lugares
$responseLugares = file_get_contents($urlLugares);  // Obtener todos los lugares desde la API
// Verificar si la respuesta es correcta
if ($responseLugares === FALSE) {
    throw new Exception("Error al obtener la lista de lugares.");
}

// Decodificar los datos JSON de los lugares
$lugares = json_decode($responseLugares, true);  // Decodificar la respuesta JSON de los lugares
if (json_last_error() !== JSON_ERROR_NONE || empty($lugares)) {
    throw new Exception("Error al procesar la lista de lugares.");
}

// Cargar Twig
require_once __DIR__ . '/../../config/twig.php';

// Renderizar la plantilla Twig
echo $twig->render('adminPajaroId.html.twig', [
    'pajaro' => $pajaro,
    'mensaje' => $mensaje,
    'avistamientos' => $avistamientos,
    'lugares' => $lugares,
    'idPajaro' => $idPajaro,
    'mensaje_error' => $mensajeError
]);