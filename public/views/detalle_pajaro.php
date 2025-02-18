<?php
// Incluir el archivo de conexión
$pdo = require_once __DIR__ . '/../../config/conectorDatabase.php';

// Obtener el ID del pájaro desde la URL utilizando una expresión regular
$request = strtok($_SERVER['REQUEST_URI'], '?'); // Obtener solo la parte de la ruta sin parámetros
preg_match('/^\/pajaro\/(\d+)$/', $request, $matches);

// Verificar si encontramos el ID del pájaro
if (isset($matches[1])) {
    $idPajaro = $matches[1];  // El ID del pájaro será el valor capturado
} else {
    http_response_code(404);
    echo "Pájaro no encontrado.";
    exit;
}

// Inicializar las variables
$pajaro = null;
$datos = null;
$avistamientos = [];

// Consultar detalles del pájaro
try {
    $stmt = $pdo->prepare("SELECT * FROM Pajaro WHERE id_pajaro = ?");
    $stmt->execute([$idPajaro]);
    $pajaro = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($pajaro) {
        // Consultar información adicional del pájaro
        $stmtDatos = $pdo->prepare("SELECT * FROM Datos WHERE id_pajaro = ?");
        $stmtDatos->execute([$idPajaro]);
        $datos = $stmtDatos->fetch(PDO::FETCH_ASSOC);

        // Consultar avistamientos del pájaro
        $stmtAvistamientos = $pdo->prepare("SELECT L.nombre, L.ubicacion FROM Avistamientos A JOIN Lugares L ON A.id_lugar = L.id_lugar WHERE A.id_pajaro = ?");
        $stmtAvistamientos->execute([$idPajaro]);
        $avistamientos = $stmtAvistamientos->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Si no se encuentra el pájaro
        http_response_code(404);
        echo "Pájaro no encontrado.";
        exit;
    }
} catch (PDOException $e) {
    error_log("Error en la consulta SQL: " . $e->getMessage());
}

// Cargar Twig
require_once __DIR__ . '/../../config/twig.php';

// Renderizar la plantilla Twig
echo $twig->render('detalle_pajaro.html.twig', [
    'pajaro' => $pajaro,
    'datos' => $datos,
    'avistamientos' => $avistamientos
]);
?>
