<?php
// Configuración de conexión
$host = 'localhost';
$dbname = 'wikiagapornis';
$username = 'usuario';
$password = 'usuario';

try {
    // Crear una conexión PDO
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password);

    // Configuración para mostrar errores en caso de fallo
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Si ocurre un error, muestra un mensaje
    echo "<h3 style='color: red;'>Error al conectar con la base de datos: " . $e->getMessage() . "</h3>";
    exit();
}

// Devuelve la conexión PDO
return $pdo;
