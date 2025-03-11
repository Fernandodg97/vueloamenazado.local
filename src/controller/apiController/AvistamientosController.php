<?php

class AvistamientosController
{

    // ### Configuracion ### /
    const OBJECT = 1;
    const JSON = 2;

    private $connection;

    public function __construct(){
        $dbController = DatabaseController::getInstance();
        $this->connection = $dbController->getConnection();
    }

    // ### Avistamientos ### /

    // Devuelve por GET todos los Avistamientos

    public static function getAvistamientos($mode = self::OBJECT)
    {
        try {

            $sql = "SELECT * FROM Avistamientos WHERE 1";

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

    // Devuelve por GET todos los Avistamientos seleccionado por id /

    public static function getAvistamientosId($id, $mode = self::OBJECT)
    {
        try {
            $sql = "SELECT id_lugar FROM Avistamientos WHERE id_pajaro = :id";

            $statement = (new self)->connection->prepare($sql);
            $statement->bindValue(":id", $id);
            $statement->setFetchMode(PDO::FETCH_ASSOC);
            $statement->execute();

            $result = $statement->fetchAll();

            // Verificar si se encontró un usuario /
            if ($result) {
                if ($mode == self::OBJECT) {
                    return $result;
                } else if ($mode == self::JSON) {
                    return json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                }
            } else {
                return json_encode(['status' => 'error', 'message' => 'Avistamientos no encontrado'], JSON_PRETTY_PRINT);
            }

        } catch (PDOException $error) {
            echo $sql . "<br>" . $error->getMessage();
        }
    }

    // Devuelve por GET todos los Avistamientos seleccionado por id pajaro /

    public static function getAvistamientosIdLugar($id, $mode = self::OBJECT)
{
    try {
        $sql = "SELECT id_pajaro FROM Avistamientos WHERE id_lugar = :id";

        $statement = (new self)->connection->prepare($sql);
        $statement->bindValue(":id", $id);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute();

        $results = $statement->fetchAll();

        // Verificar si se encontraron resultados
        if ($results) {
            if ($mode == self::OBJECT) {
                return $results;
            } else if ($mode == self::JSON) {
                return json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }
        } else {
            return json_encode(['status' => 'error', 'message' => 'Avistamientos no encontrados'], JSON_PRETTY_PRINT);
        }

    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}


    // Añade por POST los Avistamientos /

    public static function postNewAvistamientos($mode)
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
        $requiredFields = ['id_pajaro', 'id_lugar'];
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
            $sql = "INSERT INTO `Avistamientos` (`id_pajaro`, `id_lugar`) VALUES (:id_pajaro, :id_lugar)";

            $statement = (new self)->connection->prepare($sql);

            // CORREGIDO: Asignar los valores correctamente
            $statement->bindValue(':id_pajaro', $data['id_pajaro']);
            $statement->bindValue(':id_lugar', $data['id_lugar']);

            if ($statement->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Avistamiento creado correctamente.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al insertar el Avistamiento.']);
            }

        } catch (PDOException $error) {
            echo json_encode(['status' => 'error', 'message' => 'Error al insertar en la base de datos: ' . $error->getMessage()]);
        }
    }

    // Actualiza por PATCH los Avistamientos seleccionado por id pajaro y id lugar/
    public static function patchAvistamientosIdUpdate($id, $mode = self::OBJECT)
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

        // Definir el campo permitido que puede ser actualizado
        $allowedFields = ['id_lugar'];  // Solo permitir la actualización de id_lugar
        $fieldsToUpdate = [];

        // Filtramos los campos que se desean actualizar (solo id_lugar)
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
            // Construir la parte SET de la consulta dinámicamente (solo con id_lugar)
            $setClause = [];
            foreach ($fieldsToUpdate as $key => $value) {
                $setClause[] = "$key = :$key";
            }

            // Combinar las partes para la consulta SQL
            $sql = "UPDATE Avistamientos SET " . implode(', ', $setClause) . " WHERE id_pajaro = :id_pajaro";

            // Prepara la consulta PDO
            $statement = (new self)->connection->prepare($sql);

            // Asignar valores con bindValue
            foreach ($fieldsToUpdate as $key => $value) {
                $statement->bindValue(":$key", $value);
            }

            // Aquí, se usa el id_pajaro (el que ya se recibe) para filtrar el avistamiento específico
            $statement->bindValue(':id_pajaro', $id);

            // Ejecutar la consulta y verificar el resultado
            if ($statement->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Avistamiento actualizado correctamente.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al actualizar los Avistamientos.']);
            }

        } catch (PDOException $error) {
            // Captura cualquier error que ocurra durante la ejecución
            echo json_encode(['status' => 'error', 'message' => 'Error al actualizar en la base de datos: ' . $error->getMessage()]);
        }
    }


    // Elimina por DELETE los Avistamientos seleccionado por id pajaro/
    public static function deleteAvistamientosById($id)
    {
        try {
            // Define la consulta SQL para eliminar un avistamiento por ID pajaro y id lugar /
            $sql = "DELETE FROM Avistamientos WHERE id_pajaro = :id";

            // Prepara la consulta PDO /
            $statement = (new self)->connection->prepare($sql);

            // Asignar el valor del ID con bindValue /
            $statement->bindValue(':id', $id);

            // Ejecutar la consulta y verificar el resultado /
            if ($statement->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Avistamientos eliminado correctamente.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al eliminar los Avistamientos.']);
            }

        } catch (PDOException $error) {
            // Captura cualquier error que ocurra durante la ejecución /
            echo json_encode(['status' => 'error', 'message' => 'Error al eliminar en la base de datos: ' . $error->getMessage()]);
        }
    }

    // Elimina por DELETE los Avistamientos seleccionado por id_pajaro y id_lugar
    public static function deleteAvistamientosByIdPajaroIdLugar($idPajaro, $idLugar)
    {
        try {
            // Define la consulta SQL para eliminar un avistamiento por id_pajaro y id_lugar
            $sql = "DELETE FROM Avistamientos WHERE id_pajaro = :id_pajaro AND id_lugar = :id_lugar";

            // Prepara la consulta PDO
            $statement = (new self)->connection->prepare($sql);

            // Asignar los valores del ID con bindValue
            $statement->bindValue(':id_pajaro', $idPajaro);
            $statement->bindValue(':id_lugar', $idLugar);

            // Ejecutar la consulta y verificar el resultado
            if ($statement->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Avistamiento eliminado correctamente.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el avistamiento.']);
            }

        } catch (PDOException $error) {
            // Captura cualquier error que ocurra durante la ejecución
            echo json_encode(['status' => 'error', 'message' => 'Error al eliminar en la base de datos: ' . $error->getMessage()]);
        }
    }
}