<?php

class UsuarioController
{

    const OBJECT = 1;
    const JSON = 2;

    private $connection;

    public function __construct()
    {
        $this->connection = DatabaseController::connect();
    }

    // ### Hash ### /

    // Devuelve el usuario que coincide con el $token y en caso de no existir devuelve null /

    public function getHash($token) {

            try  {
           
                $sql = "SELECT * 
                        FROM User
                        WHERE token = :token";
            
                $statement = $this->connection->prepare($sql);
                $statement->bindValue(':token', $token);
                $statement->setFetchMode(PDO::FETCH_OBJ);
                $statement->execute();
    
                $result = $statement->fetch();
                return $result;
    
              } catch(PDOException $error) {
                  echo $sql . "<br>" . $error->getMessage();
              }
    }
    
    // Devuelve true si el link existe en la Base de Datos, false en caso contrario /
    public function exist($token) {
    
            try  {
           
                $sql = "SELECT * 
                        FROM User
                        WHERE token = :token";
            
                $statement = $this->connection->prepare($sql);
                $statement->bindValue(':token', $token);
                $statement->setFetchMode(PDO::FETCH_OBJ);
                $statement->execute();
    
                $result = $statement->fetch();
                return !$result ? false : true;
    
              } catch(PDOException $error) {
                  echo $sql . "<br>" . $error->getMessage();
              }
    }
    
    // Devuelve una hash de tamaño $size //
    public function generateHash($size) {
            $alphabet = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
            $max = sizeof($alphabet) - 1;
            $word = "";
            $letter = "";
            for ($i = 0; $i < $size; $i++) {
                $letter = $alphabet[rand(0, $max)];
                $word .= $letter;
            }
        
            return $word;
    }

    // ### Usuarios ### /

    // Devuelve por GET todos los usuarios /
    
    public static function getLinks($mode = self::OBJECT)
    {
        try {

            $sql = "SELECT * FROM Users";

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

    // Añade por POST los usuarios nuevos /
    public static function postNewUser($mode)
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
        $requiredFields = ['username', 'email'];
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
            // Generar un token único para el usuario utilizando la función generateHash con 32 caracteres
            $token = (new self)->generateHash(32);

            // Definir la consulta SQL para insertar un nuevo usuario en la base de datos
            $sql = "INSERT INTO Users (username, email, token) VALUES (:username, :email, :token)";

            // Preparar la consulta SQL utilizando PDO
            $statement = (new self)->connection->prepare($sql);

            // Asignar los valores de los parámetros en la consulta SQL
            $statement->bindValue(':username', $data['username']); // Nombre de usuario
            $statement->bindValue(':email', $data['email']);       // Correo electrónico
            $statement->bindValue(':token', $token);              // Token generado

            // Ejecutar la consulta SQL y verificar si la inserción fue exitosa
            if ($statement->execute()) {
                // Si la inserción fue exitosa, devolver un mensaje de éxito junto con el token generado
                echo json_encode(['status' => 'success', 'message' => 'Usuario creado correctamente.', 'token' => $token]);
            } else {
                // Si hubo un problema al insertar, devolver un mensaje de error
                echo json_encode(['status' => 'error', 'message' => 'Error al insertar el usuario.']);
            }

        } catch (PDOException $error) {
            // Capturar cualquier error que ocurra durante la ejecución de la consulta SQL
            echo json_encode(['status' => 'error', 'message' => 'Error al insertar en la base de datos: ' . $error->getMessage()]);
        }
    }

    // Devuelve por GET el usuario seleccionado por id /
    public static function getLinkId($id, $mode = self::OBJECT)
    {
        try {
            $sql = "SELECT * FROM Users WHERE id = :id";

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

    // Actualiza por PATCH el usuario seleccionado por id /
    public static function patchLinkIdUpdate($id, $mode = self::OBJECT)
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
        $allowedFields = ['username', 'email', 'token'];
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
            $sql = "UPDATE Users SET " . implode(', ', $setClause) . " WHERE id = :id";

            // Prepara la consulta PDO
            $statement = (new self)->connection->prepare($sql);

            // Asignar valores con bindValue
            foreach ($fieldsToUpdate as $key => $value) {
                $statement->bindValue(":$key", $value);
            }
            $statement->bindValue(':id', $id);

            // Ejecutar la consulta y verificar el resultado
            if ($statement->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Usuario actualizado correctamente.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el usuario.']);
            }

        } catch (PDOException $error) {
            // Captura cualquier error que ocurra durante la ejecución
            echo json_encode(['status' => 'error', 'message' => 'Error al actualizar en la base de datos: ' . $error->getMessage()]);
        }
    }

    // Elimina por DELETE el usuario seleccionado por id /
    public static function deleteUserById($id)
    {
        try {
            // Define la consulta SQL para eliminar un usuario por ID /
            $sql = "DELETE FROM Users WHERE id = :id";

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

