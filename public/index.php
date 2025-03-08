<?php
//Cargamos el archivo gettext
require_once __DIR__ . '/../config/gettext.php';

//Instanciamos Routing
$request = strtok($_SERVER['REQUEST_URI'], '?');
$viewDir = '/views/';

//Switch para configurar las rutas
if (preg_match('/^\/pajaros\/(\d+)$/', $request, $matches)) {
    $idPajaro = $matches[1]; // Obtienes el ID del pájaro
    require __DIR__ . $viewDir . 'detallePajaro.php';
} 
elseif (preg_match('/^\/admin\/pajaros\/(\d+)$/', $request, $matches)) {
    $idPajaro = $matches[1];
    require __DIR__ . $viewDir . 'adminPajaroId.php';
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
            require __DIR__ . $viewDir . 'login.php';
            break;

        case '/register':
            require __DIR__ . $viewDir . 'register.php';
            break;

        case '/forgot_password':
            require __DIR__ . $viewDir . 'forgotPassword.php';
            break;

        case '/admin':
            require __DIR__ . $viewDir . 'adminDashboard.php';
            break;

        case '/admin/lugares':
            require __DIR__ . $viewDir . 'adminLugares.php';
            break;

        case '/register_process':
            require '../process/registerProcess.php';
            break;

        case '/login_process':
            require '../process/loginProcess.php';
            break;

        case '/logout':
            require '../process/logout.php';
            break;

        default:
            http_response_code(404);
            require __DIR__ . $viewDir . '404.php';
    }
}
