<?php
// ---- Configuración de errores para depuración ----
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ---- Carga el autoload de Composer ----
require_once '../vendor/autoload.php';

// Obtener el idioma de la URL, predeterminado en español
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'es';

// Configurar el locale con el idioma seleccionado
switch ($lang) {
    case 'en':
        $locale = 'en_US.UTF-8';
        break;
    default:
        $locale = 'es_ES.UTF-8';
        break;
}

// Establecer el locale
putenv("LC_ALL=$locale");
setlocale(LC_ALL, $locale);

// Especificar el dominio y la ubicación de los archivos de traducción
bindtextdomain("messages", __DIR__ . '/../locales');
bind_textdomain_codeset("messages", "UTF-8");
textdomain("messages");