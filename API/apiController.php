<?php


class ApiController
{

    const OBJECT = 1;
    const JSON = 2;

    private $connection;

    public function __construct()
    {
        $this->connection = DatabaseController::connect();
    }

    // Devuelve por get todos los usuarios /
    public static function getLinks($mode = self::OBJECT)
    {

        try {

            $sql = "SELECT * 
                    FROM User
                    WHERE 1";


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

    // Por post añade los usuarios nuevos /
    public static function postNewUser($mode)
    {
        // Recibe el JSON /
        $input = file_get_contents('php://input');
        //Descodifica el JSON en un array asociativo /
        $data = json_decode($input, true);

        // Verificar si la decodificación fue exitosa (Salir si hay un error en el JSON) /
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(['status' => 'error', 'message' => 'Formato JSON inválido']);
            return;
        }

        // Definir los campos requeridos /
        $requiredFields = ['id', 'name', 'surname', 'email', 'dni', 'phone', 'born'];
        $missingFields = [];

        // Verificar que todos los campos necesarios están presentes /
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                // Agregar el campo faltante al array /
                $missingFields[] = $field;
            }
        }

        // Si hay campos faltantes, devolver un mensaje específico /
        if (!empty($missingFields)) {
            echo json_encode(['status' => 'error', 'message' => 'Faltan campos requeridos: ' . implode(', ', $missingFields)]);
            return;
        }

        try {

            // Define la consulta SQL para insertar un nuevo usuario /
            $sql = "INSERT INTO User 
                        (id, name, surname, email, dni, phone, born)
                    VALUES (:id, :name, :surname, :email, :dni, :phone, :born)";

            // Prepara la consulta PDO /
            $statement = (new self)->connection->prepare($sql);

            // Asignar valores con bindValue /
            $statement->bindValue(':id', $data['id']);
            $statement->bindValue(':name', $data['name']);
            $statement->bindValue(':surname', $data['surname']);
            $statement->bindValue(':email', $data['email']);
            $statement->bindValue(':dni', $data['dni']);
            $statement->bindValue(':phone', $data['phone']);
            $statement->bindValue(':born', $data['born']);

            // Ejecutar la consulta y verificar el resultado /
            if ($statement->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Usuario creado correctamente.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al insertar el usuario.']);
            }

        } catch (PDOException $error) {
            //Captura cualquier error que ocurra durante la ejecución /
            echo json_encode(['status' => 'error', 'message' => 'Error alinsertar en la base de datos: ' . $error->getMessage()]);
        }

    }

    public static function getLinkId($id, $mode = self::OBJECT)
    {
        try {

            $sql = "SELECT * 
                    FROM User
                    WHERE id = :id";


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
                return json_encode(['status' => 'error', 'message' => 'Usuario no encontrado'], JSON_PRETTY_PRINT);
            }

        } catch (PDOException $error) {
            echo $sql . "<br>" . $error->getMessage();
        }
    }
    public static function putLinkIdUpdate($id, $mode = self::OBJECT)
    {
        // Recibe el JSON /
        $input = file_get_contents('php://input');
        //Descodifica el JSON en un array asociativo /
        $data = json_decode($input, true);

        // Verificar si la decodificación fue exitosa (Salir si hay un error en el JSON) /
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(['status' => 'error', 'message' => 'Formato JSON inválido']);
            return;
        }

        // Definir los campos requeridos /
        $requiredFields = ['name', 'surname', 'email', 'dni', 'phone', 'born'];
        $missingFields = [];

        // Verificar que todos los campos necesarios están presentes /
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                // Agregar el campo faltante al array /
                $missingFields[] = $field;
            }
        }

        // Si hay campos faltantes, devolver un mensaje específico /
        if (!empty($missingFields)) {
            echo json_encode(['status' => 'error', 'message' => 'Faltan campos requeridos: ' . implode(', ', $missingFields)]);
            return;
        }

        try {

            // Define la consulta SQL para atualizar un usuario por ID /
            $sql = "UPDATE User SET name = :name, 
                    surname = :surname, 
                    email = :email, 
                    dni = :dni, 
                    phone = :phone, 
                    born = :born 
                    WHERE id = :id";

            // Prepara la consulta PDO /
            $statement = (new self)->connection->prepare($sql);

            // Asignar valores con bindValue /
            $statement->bindValue(':id', $id);
            $statement->bindValue(':name', $data['name']);
            $statement->bindValue(':surname', $data['surname']);
            $statement->bindValue(':email', $data['email']);
            $statement->bindValue(':dni', $data['dni']);
            $statement->bindValue(':phone', $data['phone']);
            $statement->bindValue(':born', $data['born']);

            // Ejecutar la consulta y verificar el resultado /
            if ($statement->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Usuario atualizado correctamente.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el usuario.']);
            }

        } catch (PDOException $error) {
            //Captura cualquier error que ocurra durante la ejecución /
            echo json_encode(['status' => 'error', 'message' => 'Error al actualizar en la base de datos: ' . $error->getMessage()]);
        }
    }
    public static function deleteUserById($id)
    {
        try {
            // Define la consulta SQL para eliminar un usuario por ID /
            $sql = "DELETE FROM User WHERE id = :id";

            // Prepara la consulta PDO /
            $statement = (new self)->connection->prepare($sql);

            // Asignar el valor del ID con bindValue /
            $statement->bindValue(':id', $id);

            // Ejecutar la consulta y verificar el resultado /
            if ($statement->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Usuario eliminado correctamente.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el usuario.']);
            }

        } catch (PDOException $error) {
            // Captura cualquier error que ocurra durante la ejecución /
            echo json_encode(['status' => 'error', 'message' => 'Error al eliminar en la base de datos: ' . $error->getMessage()]);
        }
    }

}