<?php
//Cargamos el archivo twig
require_once __DIR__ . '/../../config/twig.php';

//Verificacion de que el usuario este conectado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);

    if (SessionController::userLogIn($username, $password)) {
        redirect("/admin");
    } else {
        // Si el login falla, establecer un error en la sesión
        $_SESSION['error'] = "Nombre de usuario o contraseña incorrectos.";
        // Volver a renderizar la página de login
        echo $twig->render('login.html.twig', ['session' => $_SESSION]);
    }
}


// ---- Renderizar plantilla ----
echo $twig->render('login.html.twig');
