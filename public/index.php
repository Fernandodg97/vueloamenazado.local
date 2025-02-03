<?php
//Cargamos el archivo gettext
require_once __DIR__ . '/../config/gettext.php';

//Instanciamos Routing
$request = strtok($_SERVER['REQUEST_URI'], '?');
$viewDir = '/views/';

//Switch para configurar las rutas
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
        require __DIR__ . $viewDir . 'forgot_password.php';
        break;

    case '/admin_dashboard':
        require __DIR__ . $viewDir . 'admin_dashboard.php';
        break;      
    
    case '/register_process':
         require '../process/register_process.php';
         break;
    
    case '/login_process':
         require '../process/login_process.php';
         break;
    
    case '/logout':
        require '../process/logout.php';
        break;
        
    default:
        http_response_code(404);
        require __DIR__ . $viewDir . '404.php';
}
