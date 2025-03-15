<?php
//Cargamos el archivo twig
require_once __DIR__ . '/../../config/twig.php';

// Verificar si se recibieron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Validar que las contraseñas coincidan
    if ($password !== $confirm_password) {
        die("Las contraseñas no coinciden. Por favor, vuelve e intenta de nuevo.");
    }else{

        // Llamar a la función exist
        if( SessionController::exist($username, $email)){

            // Llamar a la función userSignUp
            if( SessionController::userSignUp($username, $email, $password)){
                header("Location: /login"); 
            }else {
                // Si el login falla, establecer un error en la sesión
                $_SESSION['error'] = "Registro fallido";
            }
            
        }else {
            // Si el login falla, establecer un error en la sesión
            $_SESSION['error'] = "Registro fallido";
        }

    }
    
}

// ---- Renderizar plantilla ----
echo $twig->render('register.html.twig');