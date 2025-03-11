<?php
//Cargamos el archivo gettext
require_once __DIR__ . '/../config/gettext.php';

//Instanciamos Routing
$request = strtok($_SERVER['REQUEST_URI'], '?');
$viewDir = '/views/';

//Funcion para redirigir
function redirect($url) {
    header("Location: $url");
    exit();
}

//Switch para configurar las rutas
if (preg_match('/^\/pajaros\/(\d+)$/', $request, $matches)) {
    $idPajaro = $matches[1]; // Obtienes el ID del pájaro
    require __DIR__ . $viewDir . 'detallePajaro.php';
} 
elseif (preg_match('/^\/admin\/pajaros\/(\d+)$/', $request, $matches)) {
    $idPajaro = $matches[1];
    if (SessionController::isLoggedIn()) {
        require __DIR__ . $viewDir . 'adminPajaroId.php';
    } else {
        redirect("/");
    }

}else {
    switch ($request) {
        case '':
        case '/':
            require __DIR__ . $viewDir . 'home.php';
            break;

        case '/contact':
            require __DIR__ . $viewDir . 'contact.php';
            break;

        case '/login':
            if (SessionController::isLoggedIn()) {
                redirect("/admin");
                break;
            } else {
                require __DIR__ . $viewDir . 'login.php';
                break;
            }

        case '/register':
            require __DIR__ . $viewDir . 'register.php';
            break;

        case '/forgot_password':
            require __DIR__ . $viewDir . 'forgotPassword.php';
            break;

        case '/admin':
            if (SessionController::isLoggedIn()) {
                require __DIR__ . $viewDir . 'adminDashboard.php';
                break;
            } else {
                redirect("/");
                break;
            }

        case '/admin/lugares':
            if (SessionController::isLoggedIn()) {
                require __DIR__ . $viewDir . 'adminLugares.php';
                break;
            } else {
                redirect("/");
                break;
            }
        

        case '/register_process':
            require '../process/registerProcess.php';
            break;

        case '/logout':
            require __DIR__ . $views . 'logout.php';
            redirect("/");
            break;

        case 'not-found':

        default:
            http_response_code(404);
            require __DIR__ . $viewDir . '404.php';
    }
}
