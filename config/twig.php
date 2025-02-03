<?php
// ---- Twig  configuracion ----
//Cargamos clases necesarias
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

// Iniciamos la sesión
session_start();

//Cargamos twig
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader, [
    'cache' => false,
]);

//Filtro para usar gettext {{ "Texto a traducir"|gettext }}
class GettextExtension extends AbstractExtension {
    public function getFilters() {
        return [
            new TwigFilter('gettext', 'gettext'),
        ];
    }
}
//Añadimos filtro al twig
$twig->addExtension(new GettextExtension());

// Pasar las variables de sesión al entorno de Twig
$twig->addGlobal('session', $_SESSION);

// Limpiar las variables de sesión después de cargarlas
function clearSessionMessages() {
    unset($_SESSION['error'], $_SESSION['success']);
}
clearSessionMessages();