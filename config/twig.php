<?php
// ---- Twig  configuracion ----
//Cargamos clases necesarias
// use Twig\Extension\AbstractExtension;
// use Twig\TwigFilter;

// Iniciamos la sesión
// session_start();

// require_once '../vendor/autoload.php';

//Cargamos twig
// $loader = new \Twig\Loader\FilesystemLoader('templates');
// $twig = new \Twig\Environment($loader, [
//     'cache' => false,
//     'autoescape' => false, // Permitir PHP en la plantilla
// ]);

//Filtro para usar gettext {{ "Texto a traducir"|gettext }}
// class GettextExtension extends AbstractExtension {
//     public function getFilters() {
//         return [
//             new TwigFilter('gettext', 'gettext'),
//         ];
//     }
// }
//Añadimos filtro al twig
// $twig->addExtension(new GettextExtension());

// Pasar las variables de sesión al entorno de Twig
// $twig->addGlobal('session', $_SESSION);

// Limpiar las variables de sesión después de cargarlas
// function clearSessionMessages() {
//     unset($_SESSION['error'], $_SESSION['success']);
// }
// clearSessionMessages();

// return $twig;

// NEW
// ---- Configuración de Twig ----

// Iniciamos la sesión
session_start();

// Cargamos Composer autoload
require_once '../vendor/autoload.php';

// Configuración de Twig
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader, [
    'cache' => false, // Desactivar caché en desarrollo (en producción usa una ruta de caché)
    'autoescape' => 'html', // Escapar automáticamente para seguridad (recomendado)
    'debug' => true, // Activar modo debug para desarrollo
]);

// Añadir extensión de depuración (solo en desarrollo)
$twig->addExtension(new \Twig\Extension\DebugExtension());

// Filtro para usar gettext {{ "Texto a traducir"|gettext }}
class GettextExtension extends \Twig\Extension\AbstractExtension {
    public function getFilters() {
        return [
            new \Twig\TwigFilter('gettext', 'gettext'),
        ];
    }
}

// Añadir el filtro de gettext a Twig
$twig->addExtension(new GettextExtension());

// Pasar las variables de sesión al entorno de Twig
$twig->addGlobal('session', $_SESSION);

// Limpiar las variables de sesión después de cargarlas
function clearSessionMessages() {
    unset($_SESSION['error'], $_SESSION['success']);
}
clearSessionMessages();

// Devolver la instancia de Twig
return $twig;