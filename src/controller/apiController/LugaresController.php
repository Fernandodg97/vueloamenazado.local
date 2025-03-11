<?php

class LugaresController
{

    // ### Configuracion ### /
    const OBJECT = 1;
    const JSON = 2;

    private $connection;

    public function __construct()
    {
        $dbController = DatabaseController::getInstance();
        $this->connection = $dbController->getConnection();
    }

    // ### Lugares ### /

    // Devuelve por GET todos los Lugares

    public static function getLugares($mode = self::OBJECT)
    {
        try {

            $sql = "SELECT * FROM Lugares WHERE 1";

            $statement = (new self)->connection->prepare($sql);
            $statement->setFetchMode(PDO::FETCH_ASSOC);
            $statement->execute();

            $result = $statement->fetchAll();

            if ($mode == self::OBJECT) {
                return $result;
            } else if ($mode == self::JSON) {
                return json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }

        } catch (PDOException $error) {
            echo $sql . "<br>" . $error->getMessage();
        }
    }

    // Devuelve por GET todos los Lugares seleccionado por id /
    public static function getLugaresId($id, $mode = self::OBJECT)
    {
        try {
            $sql = "SELECT * FROM Lugares WHERE id_lugar = :id";

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
                return json_encode(['status' => 'error', 'message' => 'Lugar no encontrado'], JSON_PRETTY_PRINT);
            }

        } catch (PDOException $error) {
            echo $sql . "<br>" . $error->getMessage();
        }
    }

    // Devuelve por GET todos los Lugares del pajaro seleccionado por id /
    public static function getLugaresIdPajaro($id, $mode = self::OBJECT)
    {
        try {
            $sql = "SELECT * FROM Lugares WHERE id_lugar = :id";

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
                return json_encode(['status' => 'error', 'message' => 'Lugar no encontrado'], JSON_PRETTY_PRINT);
            }

        } catch (PDOException $error) {
            echo $sql . "<br>" . $error->getMessage();
        }
    }

    // Añade por POST Lugares /
    public static function postNewLugares($mode)
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
        $requiredFields = ['nombre','ubicacion'];
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
            $sql = "INSERT INTO `Lugares` (`nombre`, `ubicacion`) 
                VALUES (:nombre, :ubicacion)";

            $statement = (new self)->connection->prepare($sql);

            // CORREGIDO: Asignar los valores correctamente
            $statement->bindValue(':nombre', $data['nombre']);
            $statement->bindValue(':ubicacion', $data['ubicacion']);

            if ($statement->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Lugar creado correctamente.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al insertar el Lugar.']);
            }

        } catch (PDOException $error) {
            echo json_encode(['status' => 'error', 'message' => 'Error al insertar en la base de datos: ' . $error->getMessage()]);
        }
    }

    // Actualiza por PATCH los Lugares del pajaro seleccionado por id /
    public static function patchLugaresIdUpdate($id, $mode = self::OBJECT)
    {
        // Recibe el JSON
        $input = file_get_contents('php://input');
        // Decodifica el JSON en un array asociativo
        $data = json_decode($input, true);

        // Verificar si la decodificación fue exitosa (salir si hay un error en el JSON)
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(['status' => 'error', 'message' => 'Formato JSON inválido']);
            return;
        }

        // Definir los campos que pueden ser actualizados
        $allowedFields = ['nombre','ubicacion'];
        $fieldsToUpdate = [];

        // Filtramos los campos que se desean actualizar
        foreach ($allowedFields as $field) {
            if (isset($data[$field])) {
                $fieldsToUpdate[$field] = $data[$field];
            }
        }

        // Si no hay campos para actualizar, devolver un mensaje de error
        if (empty($fieldsToUpdate)) {
            echo json_encode(['status' => 'error', 'message' => 'No se ha proporcionado ningún campo para actualizar.']);
            return;
        }

        try {
            // Construir la parte SET de la consulta dinámicamente
            $setClause = [];
            foreach ($fieldsToUpdate as $key => $value) {
                $setClause[] = "$key = :$key";
            }

            // Combinar las partes para la consulta SQL
            $sql = "UPDATE Lugares SET " . implode(', ', $setClause) . " WHERE id_lugar = :id";

            // Prepara la consulta PDO
            $statement = (new self)->connection->prepare($sql);

            // Asignar valores con bindValue
            foreach ($fieldsToUpdate as $key => $value) {
                $statement->bindValue(":$key", $value);
            }
            $statement->bindValue(':id', $id);

            // Ejecutar la consulta y verificar el resultado
            if ($statement->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Lugar actualizado correctamente.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el lugar.']);
            }

        } catch (PDOException $error) {
            // Captura cualquier error que ocurra durante la ejecución
            echo json_encode(['status' => 'error', 'message' => 'Error al actualizar en la base de datos: ' . $error->getMessage()]);
        }
    }

    // Elimina por DELETE los detalles del pajaro seleccionado por id /
    public static function deleteLugaresById($id)
    {
        try {
            // Define la consulta SQL para eliminar un usuario por ID /
            $sql = "DELETE FROM Lugares WHERE id_lugar = :id";

            // Prepara la consulta PDO /
            $statement = (new self)->connection->prepare($sql);

            // Asignar el valor del ID con bindValue /
            $statement->bindValue(':id', $id);

            // Ejecutar la consulta y verificar el resultado /
            if ($statement->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Lugar eliminado correctamente.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el Lugar.']);
            }

        } catch (PDOException $error) {
            // Captura cualquier error que ocurra durante la ejecución /
            echo json_encode(['status' => 'error', 'message' => 'Error al eliminar en la base de datos: ' . $error->getMessage()]);
        }
    }
}