<?php
// Inicializar la variable
$pajaros = [];

// Obtener la letra seleccionada desde la URL
$letra = isset($_GET['letra']) ? $_GET['letra'] : '';

try {
    // Llamada a la API
    $url = "http://www.vueloamenazado.local/api/pajaros";
    $response = file_get_contents($url);
    
    if ($response === FALSE) {
        throw new Exception("Error al obtener datos de la API");
    }
    
    // Decodificar JSON
    $pajaros = json_decode($response, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Error al decodificar JSON: " . json_last_error_msg());
    }

    // Filtrar por la letra seleccionada
    if (!empty($letra) && ctype_alpha($letra)) {
        $pajaros = array_filter($pajaros, function($pajaro) use ($letra) {
            return stripos($pajaro['nombre'], $letra) === 0;
        });
    }

} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
}

// Obtener lista de estados de conservacion 
$estadosConservacion = [];

if (is_array($pajaros)) {
    foreach ($pajaros as $pajaro) {
        if (isset($pajaro['id_pajaro'])) {
            $idPajaro = $pajaro['id_pajaro'];
            $urlPajaro = "http://www.vueloamenazado.local/api/pajaros/$idPajaro/datos";
            $responsePajaro = file_get_contents($urlPajaro);
            $datosPajaro = json_decode($responsePajaro, true);
            
            // Verificar si la respuesta es un array y tiene al menos un elemento
            if (is_array($datosPajaro) && count($datosPajaro) > 0) {
                $primerDato = $datosPajaro[0]; // Tomar el primer elemento del array
                
                if (isset($primerDato['estado_conservacion'])) {
                    $estadosConservacion[] = $primerDato['estado_conservacion'];
                }
            }
        }
    }
}

// Contar la cantidad de pájaros por estado de conservación
$conteoEstados = array_count_values($estadosConservacion);

// Contar los pájaros filtrados
try {
$totalPajaros = count($pajaros);
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
}

// Cargar Twig y renderizar la plantilla
$twig = require_once __DIR__ . '/../../config/twig.php';
echo $twig->render('home.html.twig', [
    'total_pajaros' => $totalPajaros,
    'pajaros' => $pajaros,
    'letra_seleccionada' => $letra,
    'conteo_estados' => $conteoEstados,
]);
