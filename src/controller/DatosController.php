<?php

// Cambiar return json_encode($result, JSON_PRETTY_PRINT); por  json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
class DatosController
{

    // ### Configuracion ### /
    const OBJECT = 1;
    const JSON = 2;

    private $connection;

    public function __construct()
    {
        $this->connection = DatabaseController::connect();
    }

    // ### Datos ### /

    // Devuelve por GET todos los datos /

    public static function getDatos($mode = self::OBJECT)
    {
        try {

            $sql = "SELECT * FROM Datos WHERE 1";

            $statement = (new self)->connection->prepare($sql);
            $statement->setFetchMode(PDO::FETCH_ASSOC);
            $statement->execute();

            $result = $statement->fetchAll();

            if ($mode == self::OBJECT) {
                return $result;
            } else if ($mode == self::JSON) {
                return json_encode($result, JSON_PRETTY_PRINT);
            }

        } catch (PDOException $error) {
            echo $sql . "<br>" . $error->getMessage();
        }
    }

    // Devuelve por GET todos los datos del pajaro seleccionado por id /

    public static function getDatosId($id, $mode = self::OBJECT)
    {
        try {
            $sql = "SELECT * FROM Datos WHERE id_clave = :id";

            $statement = (new self)->connection->prepare($sql);
            $statement->bindValue(":id", $id);
            $statement->setFetchMode(PDO::FETCH_ASSOC);
            $statement->execute();

            $result = $statement->fetch();

            // Verificar si se encontró un usuario /
            if ($result) {
                if ($mode == self::OBJECT) {
                    return $result;
                } else if ($mode == self::JSON) {
                    return json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                }
            } else {
                return json_encode(['status' => 'error', 'message' => 'Datos no encontrado'], JSON_PRETTY_PRINT);
            }

        } catch (PDOException $error) {
            echo $sql . "<br>" . $error->getMessage();
        }
    }

    // Añade por POST datos del pajaro /

    public static function postNewDatos($mode)
{
    // Recibe el JSON enviado en la solicitud HTTP
    $input = file_get_contents('php://input');

    // Decodifica el JSON en un array asociativo
    $data = json_decode($input, true);

    // Verificar si la decodificación fue exitosa
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['status' => 'error', 'message' => 'Formato JSON inválido']);
        return;
    }

    // Lista de campos requeridos (CORREGIDO)
    $requiredFields = ['id_pajaro', 'estado_conservacion', 'dieta', 'poblacion_europea', 'pluma', 'longitud', 'peso', 'envergadura', 'habitats'];
    $missingFields = [];

    // Verificar que todos los campos estén presentes
    foreach ($requiredFields as $field) {
        if (!isset($data[$field])) {
            $missingFields[] = $field;
        }
    }

    if (!empty($missingFields)) {
        echo json_encode(['status' => 'error', 'message' => 'Faltan campos requeridos: ' . implode(', ', $missingFields)]);
        return;
    }

    try {
        $sql = "INSERT INTO `Datos` (`id_pajaro`, `estado_conservacion`, `dieta`, `poblacion_europea`, `pluma`, `longitud`, `peso`, `envergadura`, `habitats`) 
                VALUES (:id_pajaro, :estado_conservacion, :dieta, :poblacion_europea, :pluma, :longitud, :peso, :envergadura, :habitats)";

        $statement = (new self)->connection->prepare($sql);

        // CORREGIDO: Asignar los valores correctamente
        $statement->bindValue(':id_pajaro', $data['id_pajaro']);
        $statement->bindValue(':estado_conservacion', $data['estado_conservacion']);
        $statement->bindValue(':dieta', $data['dieta']);
        $statement->bindValue(':poblacion_europea', $data['poblacion_europea']);
        $statement->bindValue(':pluma', $data['pluma']);
        $statement->bindValue(':longitud', $data['longitud']);
        $statement->bindValue(':peso', $data['peso']);
        $statement->bindValue(':envergadura', $data['envergadura']);
        $statement->bindValue(':habitats', $data['habitats']);

        if ($statement->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Datos creado correctamente.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al insertar los Datos.']);
        }

    } catch (PDOException $error) {
        echo json_encode(['status' => 'error', 'message' => 'Error al insertar en la base de datos: ' . $error->getMessage()]);
    }
}


    // Actualiza por PATCH los datos del pajaro seleccionado por id /

    // Elimina por DELETE los datos del pajaro seleccionado por id /

    public static function deleteDatosById($id)
    {
        try {
            // Define la consulta SQL para eliminar un usuario por ID /
            $sql = "DELETE FROM Datos WHERE id_clave = :id";

            // Prepara la consulta PDO /
            $statement = (new self)->connection->prepare($sql);

            // Asignar el valor del ID con bindValue /
            $statement->bindValue(':id', $id);

            // Ejecutar la consulta y verificar el resultado /
            if ($statement->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Datos eliminado correctamente.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al eliminar los Datos.']);
            }

        } catch (PDOException $error) {
            // Captura cualquier error que ocurra durante la ejecución /
            echo json_encode(['status' => 'error', 'message' => 'Error al eliminar en la base de datos: ' . $error->getMessage()]);
        }
    }
}