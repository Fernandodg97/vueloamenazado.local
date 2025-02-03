<?php
session_start();
include_once '../config/conectorDatabase.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $_SESSION['error'] = "Todos los campos son obligatorios.";
        header("Location: register");
    } elseif ($password !== $confirm_password) {
        $_SESSION['error'] = "Las contraseñas no coinciden.";
        header("Location: register");
    } else {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        try {
            $pdo = new PDO('mysql:host=localhost;dbname=wikiagapornis', 'usuario', 'usuario');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("SELECT id FROM Users WHERE username = :username OR email = :email");
            $stmt->execute([':username' => $username, ':email' => $email]);

            if ($stmt->rowCount() > 0) {
                $_SESSION['error'] = "El nombre de usuario o correo ya están registrados.";
                header("Location: register");
            } else {
                $stmt = $pdo->prepare("INSERT INTO Users (username, email, password_hash) VALUES (:username, :email, :password_hash)");
                $stmt->execute([
                    ':username' => $username,
                    ':email' => $email,
                    ':password_hash' => $password_hash
                ]);
                //$_SESSION['success'] = "Registro exitoso. Ahora puedes iniciar sesión.";
                header("Location: login");
            }
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
            $_SESSION['error'] = "Ocurrió un problema. Inténtalo más tarde.";
            header("Location: register");
        }
    }

    // Redirige a la página de registro
    exit();
} else {
    header("Location: 404");
}
?>
