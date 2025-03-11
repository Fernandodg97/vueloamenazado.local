<?php

class DatabaseController {

    private static $host = "localhost"; // Dirección del host de la base de datos
    private static $username = "usuario"; // Nombre de usuario para la conexión
    private static $password = "usuario"; // Contraseña para la conexión
    private static $dbname = "wikiagapornis"; // Nombre de la base de datos
    private static $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Modo de errores de PDO
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8" // Establecer la codificación de caracteres a UTF-8
    );

    // Mantiene la instancia de la clase.
    private static $instance = null;
    
    // Mantiene la conexión con la base de datos.
    private $connection = null;

    // El constructor es privado para evitar la creación de instancias desde fuera de la clase.
    private function __construct()
    {
        // El proceso costoso (ej. la conexión a la base de datos) se realiza aquí.
        $this->connection = $this->connect();
    }

    // El objeto se crea desde dentro de la clase solo si no existe una instancia previa.
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new DatabaseController();
        }

        return self::$instance; // Retorna la instancia única de la clase.
    }

    // Crea la conexión con la base de datos.
    private function connect() {
        try {
            // Crear una nueva conexión PDO con los parámetros especificados
            $connection = new PDO('mysql:host=' . self::$host . ';dbname=' . self::$dbname, self::$username, self::$password, self::$options);
            return $connection; // Devuelve la conexión PDO.
        } catch (PDOException $error) {
            // En caso de error en la conexión, lanza una excepción con el mensaje del error.
            throw new Exception("Fallo en la conexión a la base de datos: " . $error->getMessage());
        }
    }

    // Obtiene la conexión actual.
    public function getConnection() {
        return $this->connection; // Retorna la conexión a la base de datos.
    }
}


  //OLD

  // Configuración de conexión
// $host = 'localhost';
// $dbname = 'wikiagapornis';
// $username = 'usuario';
// $password = 'usuario';

// try {
//     // Crear una conexión PDO
//     $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
//     $pdo = new PDO($dsn, $username, $password);

//     // Configuración para mostrar errores en caso de fallo
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (PDOException $e) {
//     // Si ocurre un error, muestra un mensaje
//     echo "<h3 style='color: red;'>Error al conectar con la base de datos: " . $e->getMessage() . "</h3>";
//     exit();
// }

// // Devuelve la conexión PDO
// return $pdo;
