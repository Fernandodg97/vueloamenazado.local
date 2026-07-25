<?php
// Inicializar la variable
$pajaros = [];

// Obtener la letra seleccionada desde la URL
$letra = isset($_GET['letra']) ? $_GET['letra'] : '';

// Obtener grafico seleccionado desde la URL
$chart = $_GET['chart'] ?? 'pie';

try {
    // Llamada directa al controlador (mismo proceso, sin HTTP contra el propio servidor)
    $pajaros = PajaroController::getPajaro(PajaroController::OBJECT);

    if (!is_array($pajaros)) {
        throw new Exception("Error al obtener datos de los pájaros");
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

// Obtener lista de estados de conservacion.
// Una sola consulta con todos los datos, indexada en PHP por id_pajaro,
// en vez de una consulta por cada pájaro (evita 265 consultas secuenciales).
$estadosConservacion = [];

$todosDatos = DatosController::getDatos(DatosController::OBJECT);
if (is_array($todosDatos) && is_array($pajaros)) {
    $datosPorPajaro = [];
    foreach ($todosDatos as $dato) {
        if (isset($dato['id_pajaro'])) {
            $datosPorPajaro[$dato['id_pajaro']][] = $dato;
        }
    }

    foreach ($pajaros as $pajaro) {
        if (isset($pajaro['id_pajaro']) && !empty($datosPorPajaro[$pajaro['id_pajaro']])) {
            $primerDato = $datosPorPajaro[$pajaro['id_pajaro']][0];
            if (isset($primerDato['estado_conservacion'])) {
                $estadosConservacion[] = $primerDato['estado_conservacion'];
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
    'chart' => $chart,
]);
