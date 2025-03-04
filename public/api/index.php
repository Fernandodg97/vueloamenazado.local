<?php

// Configuración de CORS para permitir solicitudes desde cualquier origen
header("Access-Control-Allow-Origin: *"); // Permite solicitudes desde cualquier dominio
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Define los métodos HTTP permitidos
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Especifica qué encabezados se pueden enviar en la solicitud

// Manejar preflight requests (solicitudes OPTIONS que hacen los navegadores antes de ciertas peticiones)
if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
    http_response_code(200); // Responde con un código 200 OK para permitir la solicitud
    exit(); // Termina la ejecución del script
}

// Carga las dependencias necesarias (como librerías de terceros, frameworks, etc.)
// Asegúrate de que la ruta es correcta en relación con la estructura de tu proyecto
require_once "../../vendor/autoload.php";

// Obtiene la URI de la solicitud actual
$request = $_SERVER['REQUEST_URI'];

// Divide la URI en segmentos utilizando "/" como delimitador
$chunks = explode("/", $request);

// // Función para verificar autenticación del usuario
// function isUserAuthenticated() {
//     // Verifica si existe un token de autorización en los encabezados HTTP
//     if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
//         return false; // Si no hay token, el usuario no está autenticado
//     }

//     // Obtiene el encabezado de autorización
//     $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
    
//     // Extrae el token eliminando la parte "Bearer "
//     $token = str_replace("Bearer ", "", $authHeader);
    
//     // Aquí puedes validar el token, por ejemplo, con JWT u otro sistema de autenticación
//     return !empty($token); // Retorna verdadero si el token no está vacío
// }

// // Verifica la autenticación antes de permitir ciertos métodos HTTP sensibles (PUT, DELETE, POST)
// if (in_array($_SERVER["REQUEST_METHOD"], ["PATCH", "DELETE", "POST"])) {
//     // Si el usuario no está autenticado, devuelve un error 401 (No autorizado)
//     if (!isUserAuthenticated()) {
//         http_response_code(401); // Retorna un código de estado HTTP 401
//         echo json_encode(["error" => "Unauthorized"]); // Devuelve un mensaje JSON indicando que la autenticación es requerida
//         exit(); // Termina la ejecución del script
//     }
// }

// Estructura de enrutamiento basada en la URI de la solicitud
switch ($chunks[2] ?? '') { // Verifica el tercer segmento de la URI (índice 2 del array)
    case '':
    case '/':
        // Si la ruta está vacía o es "/", devuelve un error 401 (No autorizado)
        http_response_code(401);
        echo json_encode(["error" => "Unauthorized"]);
        exit();

    // ### Usuario ### /    

    case 'usuario': // Si la solicitud está relacionada con "usuario"
        if (!empty($chunks[3])) { // Si hay un cuarto segmento en la URI, se asume que es un ID de usuario
            $userId = $chunks[3];
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                // Llama al método para obtener los datos de un usuario específico
                echo UsuarioController::getLinkId($userId, UsuarioController::JSON);
            } elseif ($_SERVER["REQUEST_METHOD"] == "PATCH") {
                // Llama al método para actualizar los datos de un usuario
                echo UsuarioController::patchLinkIdUpdate($userId, UsuarioController::JSON);
            } elseif ($_SERVER["REQUEST_METHOD"] == "DELETE") {
                // Llama al método para eliminar un usuario
                echo UsuarioController::deleteUserById($userId);
            }
        } else { // Si no hay un ID de usuario en la URI
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                // Llama al método para obtener todos los usuarios
                echo UsuarioController::getLinks(UsuarioController::JSON);
            } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Llama al método para crear un nuevo usuario
                echo UsuarioController::postNewUser(UsuarioController::JSON);
            }
        }
        exit();

    // ### Pajaro ### /

    case 'pajaro':
        if (!empty($chunks[3])) {
            $pajaroId = $chunks[3];
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                // Llama al método para obtener los datos de un pajaro específico
                echo PajaroController::getPajaroId($pajaroId, PajaroController::JSON);
            } elseif ($_SERVER["REQUEST_METHOD"] == "PATCH") {
                // Llama al método para actualizar los datos de un pajaro
                echo PajaroController::patchPajaroIdUpdate($pajaroId, PajaroController::JSON);
            } elseif ($_SERVER["REQUEST_METHOD"] == "DELETE") {
                // Llama al método para eliminar un pajaro
                echo PajaroController::deletePajaroById($pajaroId);
            }
        }
        else{
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                // Llama al método para obtener todos los pajaros
                echo PajaroController::getPajaro(PajaroController::JSON);
            } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Llama al método para crear un nuevo pajaro
                echo PajaroController::postNewPajaro(PajaroController::JSON);
            }
        }
        exit();

    // ### Datos ### /
    case 'datos':
        if (!empty($chunks[3])) {
            $pajaroId = $chunks[3];
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                // Llama al método para obtener los datos de un pajaro específico
                echo DatosController::getDatosId($pajaroId, DatosController::JSON);
            } elseif ($_SERVER["REQUEST_METHOD"] == "PATCH") {
                // Llama al método para actualizar los datos de un pajaro
                echo DatosController::patchDatosIdUpdate($pajaroId, DatosController::JSON);
            } elseif ($_SERVER["REQUEST_METHOD"] == "DELETE") {
                // Llama al método para eliminar un pajaro
                echo DatosController::deleteDatosById($pajaroId);
            }
        }
        else{
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                // Llama al método para obtener todos los pajaros
                echo DatosController::getDatos(DatosController::JSON);
            } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Llama al método para crear un nuevo pajaro
                echo DatosController::postNewDatos(DatosController::JSON);
            }
        }
        exit();

    default:
        // Si la ruta no coincide con ninguna de las anteriores, devuelve un error 404 (No encontrado)
        http_response_code(404);
        echo json_encode(["error" => "Not Found"]);
        exit();
}
