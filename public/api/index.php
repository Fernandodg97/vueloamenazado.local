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

// Función para verificar autenticación del usuario
session_start();

// Si no es una peticion GET y el usuario no esta validado manda un erro en formato JSON
if ($_SERVER["REQUEST_METHOD"] !== "GET" && !SessionController::isLoggedIn()) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

// Estructura de enrutamiento basada en la URI de la solicitud
switch ($chunks[2] ?? '') { // Verifica el tercer segmento de la URI (índice 2 del array)
    case '':
    case '/':
        // Si la ruta está vacía o es "/", devuelve un error 401 (No autorizado)
        http_response_code(401);
        echo json_encode(["error" => "Unauthorized"]);
        exit();

    // ### Usuario ### /    

    // case 'usuario': // Si la solicitud está relacionada con "usuario"
    //     if (!empty($chunks[3])) { // Si hay un cuarto segmento en la URI, se asume que es un ID de usuario
    //         $userId = $chunks[3];
    //         if ($_SERVER["REQUEST_METHOD"] == "GET") {
    //             // Llama al método para obtener los datos de un usuario específico
    //             echo UsuarioController::getLinkId($userId, UsuarioController::JSON);
    //         } elseif ($_SERVER["REQUEST_METHOD"] == "PATCH") {
    //             // Llama al método para actualizar los datos de un usuario
    //             echo UsuarioController::patchLinkIdUpdate($userId, UsuarioController::JSON);
    //         } elseif ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    //             // Llama al método para eliminar un usuario
    //             echo UsuarioController::deleteUserById($userId);
    //         }
    //     } else { // Si no hay un ID de usuario en la URI
    //         if ($_SERVER["REQUEST_METHOD"] == "GET") {
    //             // Llama al método para obtener todos los usuarios
    //             echo UsuarioController::getLinks(UsuarioController::JSON);
    //         } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    //             // Llama al método para crear un nuevo usuario
    //             echo UsuarioController::postNewUser(UsuarioController::JSON);
    //         }
    //     }
    //     exit();

    // ### Pajaro ### /

    case 'pajaros':
        // ### Avistamientos de pajaro ### /
        if(!empty($chunks[4])){
            $pajaroId = $chunks[3];
            if ($_SERVER["REQUEST_METHOD"] == "GET" && $chunks[4] == "avistamientos") {
                // Llama al método para obtener los datos de un pajaro específico
                echo AvistamientosController::getAvistamientosId($pajaroId, AvistamientosController::JSON);
            }
            else if($_SERVER["REQUEST_METHOD"] == "GET" && $chunks[4] == "detalles") {
                // Llama al método para obtener los datos de un pajaro específico
                echo DatosController::getDatosIdPajaro($pajaroId, DatosController::JSON);
            }

        }
        else if (!empty($chunks[3])) {
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
            $datosId = $chunks[3];
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                // Llama al método para obtener los datos de un pajaro específico
                echo DatosController::getDatosId($datosId, DatosController::JSON);
            } elseif ($_SERVER["REQUEST_METHOD"] == "PATCH") {
                // Llama al método para actualizar los datos de un pajaro
                echo DatosController::patchDatosIdUpdate($datosId, DatosController::JSON);
            } elseif ($_SERVER["REQUEST_METHOD"] == "DELETE") {
                // Llama al método para eliminar un pajaro
                echo DatosController::deleteDatosById($datosId);
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

    // ### Lugares ### /
    case 'lugares':
        // ### Avistamientos de pajaro ### /
        if(!empty($chunks[4])){
            $lugarId = $chunks[3];
            if ($_SERVER["REQUEST_METHOD"] == "GET" && $chunks[4] == "pajaros") {
                // Llama al método para obtener los pajaros de ese lugar
                echo AvistamientosController::getAvistamientosIdLugar($lugarId, AvistamientosController::JSON);
            }
        }
        else if (!empty($chunks[3])) {
            $lugarId = $chunks[3];
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                // Llama al método para obtener los datos de un pajaro específico
                echo LugaresController::getLugaresId($lugarId, LugaresController::JSON);
            } elseif ($_SERVER["REQUEST_METHOD"] == "PATCH") {
                // Llama al método para actualizar los datos de un pajaro
                echo LugaresController::patchLugaresIdUpdate($lugarId, LugaresController::JSON);
            } elseif ($_SERVER["REQUEST_METHOD"] == "DELETE") {
                // Llama al método para eliminar un pajaro
                echo LugaresController::deleteLugaresById($lugarId);
            }
        }
        else{
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                // Llama al método para obtener todos los pajaros
                echo LugaresController::getLugares(LugaresController::JSON);
            } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Llama al método para crear un nuevo pajaro
                echo LugaresController::postNewLugares(LugaresController::JSON);
            }
        }
        exit();

    // ### Avistamientos ### /
    case 'avistamientos':
        if (!empty($chunks[3])) {
            $avistamientoId = $chunks[3];

            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                // Llama al método para obtener los datos de un avistamiento específico
                echo AvistamientosController::getAvistamientosId($avistamientoId, AvistamientosController::JSON);
            } elseif ($_SERVER["REQUEST_METHOD"] == "PATCH") {
                // Llama al método para actualizar los datos del avistamiento
                echo AvistamientosController::patchAvistamientosIdUpdate($avistamientoId, AvistamientosController::JSON);
            } elseif ($_SERVER["REQUEST_METHOD"] == "DELETE") {
                // Llama al método para eliminar un avistamiento por id_pajaro e id_lugar
                // Se asume que el id_pajaro y el id_lugar se pasan en la URL de la siguiente forma:
                // /avistamientos/{id_pajaro}/{id_lugar}
                if (!empty($chunks[4])) {
                    $idPajaro = $chunks[3]; // id_pajaro
                    $idLugar = $chunks[4];  // id_lugar
                    echo AvistamientosController::deleteAvistamientosByIdPajaroIdLugar($idPajaro, $idLugar);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Faltan parámetros de id_pajaro o id_lugar.']);
                }
            }
        } else {
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                // Llama al método para obtener todos los avistamientos
                echo AvistamientosController::getAvistamientos(AvistamientosController::JSON);
            } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Llama al método para crear un nuevo avistamiento
                echo AvistamientosController::postNewAvistamientos(AvistamientosController::JSON);
            }
        }
        exit();


    default:
        // Si la ruta no coincide con ninguna de las anteriores, devuelve un error 404 (No encontrado)
        http_response_code(404);
        echo json_encode(["error" => "Not Found"]);
        exit();
}
