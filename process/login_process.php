<?php
session_start();

// Incluir el archivo de conexión a la base de datos
$pdo = require '../config/conectorDatabase.php';

// Verificar si se enviaron los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        try {
            // Preparar y ejecutar la consulta para obtener el usuario
            $stmt = $pdo->prepare("SELECT id, username, password_hash FROM Users WHERE username = :username");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password_hash'])) {
                // Guardar información en la sesión
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                // Redirigir al usuario al panel de administración o página principal
                header("Location: admin_dashboard");
                exit();
            } else {
                // Usuario o contraseña incorrectos
                $_SESSION['error'] = "Usuario o contraseña incorrectos.";
            }
        } catch (PDOException $e) {
            // Error en la base de datos
            $_SESSION['error'] = "Error al verificar las credenciales. Inténtalo más tarde.";
        }
    } else {
        $_SESSION['error'] = "Por favor, rellena todos los campos.";
    }

    // Redirigir de vuelta a la página de login en caso de error
    header("Location: login");
    exit();
}
?>
