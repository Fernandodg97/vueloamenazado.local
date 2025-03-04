<?php

class PajaroController
{

    // ### Configuracion ### /
    const OBJECT = 1;
    const JSON = 2;

    private $connection;

    public function __construct()
    {
        $this->connection = DatabaseController::connect();
    }

    // ### Pajaros ### /

    // Devuelve por GET todos los pajaros /

    public static function getPajaro($mode = self::OBJECT)
    {
        try {

            $sql = "SELECT * FROM Pajaro WHERE 1";

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

    // Añade por POST los pajaros nuevos /
    public static function postNewPajaro($mode)
    {
        // Recibe el JSON enviado en la solicitud HTTP
        $input = file_get_contents('php://input');
        
        // Decodifica el JSON en un array asociativo
        $data = json_decode($input, true);

        // Verificar si la decodificación fue exitosa
        if (json_last_error() !== JSON_ERROR_NONE) {
            // Si hay un error en el JSON, devolver un mensaje de error
            echo json_encode(['status' => 'error', 'message' => 'Formato JSON inválido']);
            return;
        }

        // Definir los campos requeridos para la creación del usuario
        $requiredFields = ['nombre', 'nombre_cientifico', 'grupo', 'imagen', 'como_identificar', 'canto_audio'];
        $missingFields = [];

        // Verificar que todos los campos necesarios están presentes en el JSON recibido
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                // Si falta algún campo, agregarlo a la lista de campos faltantes
                $missingFields[] = $field;
            }
        }

        // Si hay campos faltantes, devolver un mensaje específico con los nombres de los campos ausentes
        if (!empty($missingFields)) {
            echo json_encode(['status' => 'error', 'message' => 'Faltan campos requeridos: ' . implode(', ', $missingFields)]);
            return;
        }

        try {
            // Definir la consulta SQL para insertar un nuevo usuario en la base de datos
            $sql = "INSERT INTO Pajaro (nombre, nombre_cientifico, grupo, imagen, como_identificar, canto_audio) VALUES (:nombre, :nombre_cientifico, :grupo, :imagen, :como_identificar, :canto_audio)";

            // Preparar la consulta SQL utilizando PDO
            $statement = (new self)->connection->prepare($sql);

            // Asignar los valores de los parámetros en la consulta SQL
            $statement->bindValue(':nombre', $data['nombre']);
            $statement->bindValue(':nombre_cientifico', $data['nombre_cientifico']);
            $statement->bindValue(':grupo', $data['grupo']); 
            $statement->bindValue(':imagen', $data['imagen']);
            $statement->bindValue(':como_identificar', $data['como_identificar']);
            $statement->bindValue(':canto_audio', ['canto_audio']);

            // Ejecutar la consulta SQL y verificar si la inserción fue exitosa
            if ($statement->execute()) {
                // Si la inserción fue exitosa, devolver un mensaje de éxito
                echo json_encode(['status' => 'success', 'message' => 'Pajaro creado correctamente.']);
            } else {
                // Si hubo un problema al insertar, devolver un mensaje de error
                echo json_encode(['status' => 'error', 'message' => 'Error al insertar el pajaro.']);
            }

        } catch (PDOException $error) {
            // Capturar cualquier error que ocurra durante la ejecución de la consulta SQL
            echo json_encode(['status' => 'error', 'message' => 'Error al insertar en la base de datos: ' . $error->getMessage()]);
        }
    }
    // Devuelve por GET el pajaro seleccionado por id /

    public static function getPajaroId($id, $mode = self::OBJECT)
    {
        try {
            $sql = "SELECT * FROM Pajaro WHERE id_pajaro = :id";

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
                    return json_encode($result, JSON_PRETTY_PRINT);
                }
            } else {
                return json_encode(['status' => 'error', 'message' => 'Pajaro no encontrado'], JSON_PRETTY_PRINT);
            }

        } catch (PDOException $error) {
            echo $sql . "<br>" . $error->getMessage();
        }
    }

    // Actualiza por PATCH el pajaro seleccionado por id /
    public static function patchPajaroIdUpdate($id, $mode = self::OBJECT)
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
        $allowedFields = ['nombre', 'nombre_cientifico', 'grupo', 'imagen', 'como_identificar', 'canto_audio'];
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
            $sql = "UPDATE Pajaro SET " . implode(', ', $setClause) . " WHERE id_pajaro = :id";

            // Prepara la consulta PDO
            $statement = (new self)->connection->prepare($sql);

            // Asignar valores con bindValue
            foreach ($fieldsToUpdate as $key => $value) {
                $statement->bindValue(":$key", $value);
            }
            $statement->bindValue(':id', $id);

            // Ejecutar la consulta y verificar el resultado
            if ($statement->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Pajaro actualizado correctamente.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el Pajaro.']);
            }

        } catch (PDOException $error) {
            // Captura cualquier error que ocurra durante la ejecución
            echo json_encode(['status' => 'error', 'message' => 'Error al actualizar en la base de datos: ' . $error->getMessage()]);
        }
    }

    // Elimina por DELETE el pajaro seleccionado por id /

    public static function deletePajaroById($id)
    {
        try {
            // Define la consulta SQL para eliminar un usuario por ID /
            $sql = "DELETE FROM Pajaro WHERE id_pajaro = :id";

            // Prepara la consulta PDO /
            $statement = (new self)->connection->prepare($sql);

            // Asignar el valor del ID con bindValue /
            $statement->bindValue(':id', $id);

            // Ejecutar la consulta y verificar el resultado /
            if ($statement->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Pajaro eliminado correctamente.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el Pajaro.']);
            }

        } catch (PDOException $error) {
            // Captura cualquier error que ocurra durante la ejecución /
            echo json_encode(['status' => 'error', 'message' => 'Error al eliminar en la base de datos: ' . $error->getMessage()]);
        }
    }
}