<?php
// ---- Configuración de errores para depuración ----
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ---- Carga el autoload de Composer ----
require_once __DIR__ . '/../vendor/autoload.php';

// Iniciar sesión primero
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Obtener el idioma: primero de URL, luego de sesión, luego default
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    setcookie('lang', $lang, time() + 2592000, '/');
    $url = strtok($_SERVER['REQUEST_URI'], '?');
    if (isset($_GET['letra'])) {
        $url = $url . '?letra=' . $_GET['letra'];
    }
    header("Location: " . $url);
    exit();
} elseif (isset($_COOKIE['lang'])) {
    $lang = $_COOKIE['lang'];
} else {
    $lang = 'es';
}

$GLOBALS['lang'] = $lang;

// Función para cargar traducciones desde archivos .mo
function load_translations($lang)
{
    static $cache = [];

    if (isset($cache[$lang])) {
        return $cache[$lang];
    }

    $langMapping = [
        'en' => 'en_US.UTF-8',
        'es' => 'es_ES.UTF-8'
    ];

    $locale = $langMapping[$lang] ?? 'es_ES.UTF-8';
    $moFile = __DIR__ . "/../locales/{$locale}/LC_MESSAGES/messages.mo";

    $translations = [];

    if (!file_exists($moFile)) {
        $cache[$lang] = [];
        return [];
    }

    $fp = fopen($moFile, 'rb');
    if (!$fp) {
        return [];
    }

    // Leer magic number para detectar endianness
    $data = fread($fp, 4);
    if (strlen($data) < 4) {
        fclose($fp);
        return [];
    }

    $magicLE = unpack('V', $data)[1];
    $magicBE = unpack('N', $data)[1];

    if ($magicLE == 0x950412de) {
        // El archivo es little endian
        $formatInt = 'V';
    } elseif ($magicBE == 0x950412de) {
        // El archivo es big endian
        $formatInt = 'N';
    } else {
        // Magic number no válido
        fclose($fp);
        return [];
    }

    // Leer header
    fseek($fp, 0);
    $headerData = fread($fp, 28);
    $header = unpack("{$formatInt}magic/{$formatInt}version/{$formatInt}count/{$formatInt}origTableOffset/{$formatInt}transTableOffset/{$formatInt}hashTableSize/{$formatInt}hashTableOffset", $headerData);

    if (!is_array($header) || !isset($header['count'])) {
        fclose($fp);
        return [];
    }

    $count = $header['count'];
    $origTableOffset = $header['origTableOffset'];
    $transTableOffset = $header['transTableOffset'];

    // Leer tabla de originales
    fseek($fp, $origTableOffset);
    $origTable = [];
    for ($i = 0; $i < $count; $i++) {
        $data = fread($fp, 8);
        if (strlen($data) != 8) break;
        $entry = unpack("{$formatInt}len/{$formatInt}offset", $data);
        $origTable[] = $entry;
    }

    // Leer tabla de traducciones
    fseek($fp, $transTableOffset);
    $transTable = [];
    for ($i = 0; $i < $count; $i++) {
        $data = fread($fp, 8);
        if (strlen($data) != 8) break;
        $entry = unpack("{$formatInt}len/{$formatInt}offset", $data);
        $transTable[] = $entry;
    }

    // Leer las cadenas
    for ($i = 0; $i < $count; $i++) {
        if ($origTable[$i]['len'] == 0) {
            continue;
        }

        fseek($fp, $origTable[$i]['offset']);
        $msgid = fread($fp, $origTable[$i]['len']);

        fseek($fp, $transTable[$i]['offset']);
        $msgstr = fread($fp, $transTable[$i]['len']);

        if (!empty($msgid) && !empty($msgstr)) {
            $translations[$msgid] = $msgstr;
        }
    }

    fclose($fp);
    $cache[$lang] = $translations;

    return $translations;
}

// Función gettext personalizada
function _translate($text)
{
    global $lang;
    static $translations = [];

    if (!isset($translations[$lang])) {
        $translations[$lang] = load_translations($lang);
    }

    return isset($translations[$lang][$text]) ? $translations[$lang][$text] : $text;
}

// Redefinir gettext
if (!function_exists('gettext')) {
    function gettext($text)
    {
        return _translate($text);
    }
}
