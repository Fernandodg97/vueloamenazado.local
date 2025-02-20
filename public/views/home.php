<?php
// Incluir el archivo de conexión
$pdo = require_once __DIR__ . '/../../config/conectorDatabase.php';

if (!$pdo instanceof PDO) {
    die("Error: No se pudo conectar a la base de datos.");
}

// Inicializar la variable
$pajaros = [];

try {
    // Consultar datos de la tabla Pajaro
    $stmt = $pdo->query("SELECT * FROM Pajaro");
    $pajaros = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Verificar si se obtuvieron datos
    if (!$pajaros) {
        error_log("No se encontraron registros en la tabla Pajaro.");
    }
} catch (PDOException $e) {
    error_log("Error en la consulta SQL: " . $e->getMessage());
}

//Cargamos el archivo twig
$twig = require_once __DIR__ . '/../../config/twig.php';

if (empty($pajaros)) {
    error_log("No hay datos en la variable \$pajaros.");
} else {
    error_log("Se encontraron " . count($pajaros) . " registros.");
}

// ---- Variables Twig ----
$data = [
    'name' => 'Fernando Díaz',
    'age' => '27',
    'lang' => $lang,
];

// ---- Renderizar plantilla ----
echo $twig->render('home.html.twig', array_merge($data, ['pajaros' => $pajaros]));

