<?php

// Inicializar variables
$lugar = null;  // Variable para almacenar un lugar específico
$lugares = [];  // Variable para almacenar todos los lugares
$mensaje = "";  // Variable para almacenar mensajes de error o éxito
$avistamientos = [];  // Variable para almacenar los avistamientos asociados al lugar

// Obtener detalles del lugar y avistamientos desde la API
try {
    // Obtener datos del lugar (uno específico)
    $urlLugar = "http://www.vueloamenazado.local/api/lugares";  // URL para obtener el lugar
    $responseLugar = file_get_contents($urlLugar);  // Obtener los datos del lugar desde la API

    // Verificar si la respuesta es correcta
    if ($responseLugar === FALSE) {
        throw new Exception("Error al obtener detalles del lugar.");
    }

    // Decodificar los datos JSON del lugar
    $lugarArray = json_decode($responseLugar, true);  // Decodificar la respuesta JSON
    if (json_last_error() !== JSON_ERROR_NONE || empty($lugarArray)) {
        throw new Exception("Error al procesar datos del lugar.");
    }
    $lugar = $lugarArray[0]; // Tomamos el primer lugar, si lo hay

    // Obtener avistamientos del lugar, si el lugar tiene ID
    if ($lugar) {
        // Obtener los avistamientos asociados al lugar
        $urlAvistamientos = "http://www.vueloamenazado.local/api/lugares/" . $lugar['id_lugar'] . "/pajaros";
        $responseAvistamientos = file_get_contents($urlAvistamientos);  // Obtener los avistamientos del lugar

        // Verificar si la respuesta es correcta
        if ($responseAvistamientos !== FALSE) {
            $avistamientos = json_decode($responseAvistamientos, true);  // Decodificar los avistamientos
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

} catch (Exception $e) {
    // Manejar errores en la obtención de datos
    $mensaje = "Error: " . $e->getMessage();  // Almacenar el mensaje de error
}

// Procesar solicitudes POST, PATCH y DELETE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si se usa el campo _method para simular un PATCH o DELETE
    if (isset($_POST['_method'])) {
        // Si el _method es PATCH, actualizar el lugar
        if ($_POST['_method'] === 'PATCH' && isset($_POST['id'])) {
            $id = $_POST['id'];  // Obtener el ID del lugar
            $data = json_encode([
                'nombre' => $_POST['nombre'],
                'ubicacion' => $_POST['ubicacion'],
            ]);

            // Realizar la solicitud PATCH para actualizar el lugar
            $urlPatch = 'http://www.vueloamenazado.local/api/lugares/' . $id;
            $options = [
                'http' => [
                    'method' => 'PATCH',  // Definir el método HTTP
                    'header' => 'Content-Type: application/json',  // Especificar el tipo de contenido
                    'content' => $data,  // Incluir los datos a actualizar
                ]
            ];
            $context = stream_context_create($options);  // Crear el contexto de la solicitud
            $response = file_get_contents($urlPatch, false, $context);  // Ejecutar la solicitud

            if ($response === FALSE) {
                $mensaje = "Error al actualizar el lugar.";  // Mensaje de error si la actualización falla
            } else {
                $mensaje = "Lugar actualizado exitosamente.";  // Mensaje de éxito si la actualización es exitosa
            }

            // Redirigir después de la actualización
            header("Location:/admin/lugares");
            exit();
        }

        // Si el _method es DELETE, eliminar el lugar
        elseif ($_POST['_method'] === 'DELETE' && isset($_POST['id'])) {
            $id = $_POST['id'];  // Obtener el ID del lugar

            // Realizar la solicitud DELETE para eliminar el lugar
            $urlDelete = 'http://www.vueloamenazado.local/api/lugares/' . $id;
            $options = [
                'http' => [
                    'method' => 'DELETE',  // Definir el método HTTP para eliminar
                ]
            ];
            $context = stream_context_create($options);  // Crear el contexto de la solicitud
            $response = file_get_contents($urlDelete, false, $context);  // Ejecutar la solicitud

            if ($response === FALSE) {
                $mensaje = "Error al eliminar el lugar.";  // Mensaje de error si la eliminación falla
            } else {
                $mensaje = "Lugar eliminado exitosamente.";  // Mensaje de éxito si la eliminación es exitosa
            }

            // Redirigir después de la eliminación
            header("Location:/admin/lugares");
            exit();
        }
    }
    // Si no es ni PATCH ni DELETE, se asume que es un POST normal para crear un lugar
    else {
        $data = json_encode([
            'nombre' => $_POST['nombre'],
            'ubicacion' => $_POST['ubicacion'],
        ]);

        // Realizar la solicitud POST para crear el lugar
        $urlPost = 'http://www.vueloamenazado.local/api/lugares';
        $options = [
            'http' => [
                'method' => 'POST',  // Definir el método HTTP para crear
                'header' => 'Content-Type: application/json',  // Especificar el tipo de contenido
                'content' => $data,  // Incluir los datos a crear
            ]
        ];
        $context = stream_context_create($options);  // Crear el contexto de la solicitud
        $response = file_get_contents($urlPost, false, $context);  // Ejecutar la solicitud

        if ($response === FALSE) {
            $mensaje = "Error al crear el lugar.";  // Mensaje de error si la creación falla
        } else {
            $mensaje = "Lugar creado exitosamente.";  // Mensaje de éxito si la creación es exitosa
        }

        // Redirigir después de crear el lugar
        header("Location:/admin/lugares");
        exit();
    }
}


// Cargar Twig
require_once __DIR__ . '/../../config/twig.php';  // Incluir la configuración de Twig

// Renderizar la plantilla Twig
echo $twig->render('adminLugares.html.twig', [
    'lugares' => $lugares,  // Pasar la lista de lugares a la plantilla
    'mensaje' => $mensaje,  // Pasar el mensaje a la plantilla
    'avistamientos' => $avistamientos  // Pasar los avistamientos a la plantilla
]);