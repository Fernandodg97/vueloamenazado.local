<?php

class SesionController {
    // Iniciar sesión
    public static function iniciarSesion($usuarioId, $usuarioNombre, $pdo) {
        // Iniciar la sesión
        session_start();

        // Guardar información de la sesión
        $_SESSION['usuario_id'] = $usuarioId;
        $_SESSION['nombre_usuario'] = $usuarioNombre;

        // Generar un token único para mantener la sesión persistente
        $token = bin2hex(random_bytes(16));

        // Guardar el token en la base de datos asociado con el usuario
        $query = "UPDATE usuarios SET token = ? WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$token, $usuarioId]);

        // Establecer la cookie con el token de sesión persistente
        setcookie('usuario_token', $token, time() + (30 * 24 * 60 * 60), '/', null, false, true); // 30 días

        // Redirigir al panel de administración o página principal
        header("Location: /admin");
        exit;
    }

    // Verificar si el usuario está autenticado (iniciar sesión automáticamente si la cookie está presente)
    public static function verificarSesion($pdo) {
        session_start();

        // Verificar si la cookie 'usuario_token' está presente
        if (isset($_COOKIE['usuario_token'])) {
            $token = $_COOKIE['usuario_token'];

            // Verificar si el token es válido
            $query = "SELECT id, nombre FROM usuarios WHERE token = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$token]);
            $usuario = $stmt->fetch();

            if ($usuario) {
                // Si el token es válido, inicializar sesión para el usuario
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['nombre_usuario'] = $usuario['nombre'];

                return true; // Usuario autenticado
            }
        }

        return false; // No autenticado
    }

    // Cerrar sesión y eliminar la cookie
    public static function cerrarSesion() {
        session_start(); // Asegúrate de iniciar la sesión

        // Destruir todas las variables de sesión
        session_unset();
        session_destroy();

        // Eliminar la cookie de sesión persistente
        setcookie('usuario_token', '', time() - 3600, '/', null, false, true); // Expirar la cookie

        // Redirigir al login o página principal
        header("Location: /login");
        exit;
    }
}


// 3. Explicación del Código
// Iniciar sesión (iniciarSesion)
// Cuando un usuario inicia sesión correctamente (por ejemplo, después de verificar el nombre de usuario y la contraseña), se inicia una sesión con session_start().
// Guardamos el ID de usuario y el nombre de usuario en la sesión.
// Generamos un token único y lo guardamos en la base de datos asociado con el usuario.
// Establecemos una cookie usuario_token que contiene el token y tiene una duración de 30 días.
// Finalmente, redirigimos al usuario al panel de administración o la página principal.
// Verificar sesión (verificarSesion)
// En cada solicitud, verificamos si existe la cookie usuario_token.
// Si la cookie está presente, verificamos el token en la base de datos.
// Si el token es válido, restauramos la sesión con la información del usuario y lo autenticamos automáticamente.
// Cerrar sesión (cerrarSesion)
// Destruimos las variables de sesión con session_unset() y session_destroy().
// Eliminamos la cookie usuario_token para asegurarnos de que la sesión persistente también se elimine.
// Redirigimos al usuario al formulario de login o a la página principal.
// 4. Uso del Controlador en tu Aplicación
// Ejemplo de Login:
// Cuando un usuario inicia sesión, puedes usar el SesionController de la siguiente manera:

// php
// Copiar
// Editar
// Asumiendo que tienes un formulario de login con el usuario y contraseña

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     Obtener datos del formulario
//     $usuario = $_POST['usuario'];
//     $contrasena = $_POST['contrasena'];

//     Verificar las credenciales en la base de datos
//     $query = "SELECT id, nombre, contrasena FROM usuarios WHERE usuario = ?";
//     $stmt = $pdo->prepare($query);
//     $stmt->execute([$usuario]);
//     $usuarioDatos = $stmt->fetch();

//     if ($usuarioDatos && password_verify($contrasena, $usuarioDatos['contrasena'])) {
//         Si las credenciales son correctas, iniciar sesión
//         SesionController::iniciarSesion($usuarioDatos['id'], $usuarioDatos['nombre'], $pdo);
//     } else {
//         echo "Credenciales incorrectas.";
//     }
// }
// Ejemplo de Verificación en Páginas Protegidas:
// Antes de mostrar cualquier página protegida, verifica si el usuario está autenticado:

// php
// Copiar
// Editar
// Iniciar la sesión y verificar si el usuario está autenticado
// if (!SesionController::verificarSesion($pdo)) {
//     Si no está autenticado, redirigir al login
//     header("Location: /login");
//     exit;
// }
// Ejemplo de Cierre de Sesión:
// Cuando el usuario decide cerrar sesión, puedes llamar a SesionController::cerrarSesion():

// php
// Copiar
// Editar
// Cuando el usuario decide cerrar sesión
// SesionController::cerrarSesion();
// 5. Configuración de PDO
// Asegúrate de que tu archivo config.php tenga la configuración correcta para la conexión a la base de datos con PDO:

// php
// Copiar
// Editar
// <?php
// $dsn = 'mysql:host=localhost;dbname=nombre_base_datos';
// $username = 'usuario_bd';
// $password = 'contraseña_bd';

// try {
//     $pdo = new PDO($dsn, $username, $password);
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (PDOException $e) {
//     echo 'Error de conexión: ' . $e->getMessage();
//     exit;
// }
// Resumen
// Este controlador maneja las funciones básicas de autenticación y gestión de sesión, permitiendo que el usuario permanezca conectado incluso si cierra el navegador. Utiliza cookies persistentes y sesiones para mantener la autenticación.