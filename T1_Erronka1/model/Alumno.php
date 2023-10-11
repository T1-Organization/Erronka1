<?php

class Alumno {
    private $id;
    private $nombre;
    private $apellido;
    private $email;
    private $edad;

    public function __construct($id,$nombre, $apellido, $email, $edad) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->edad = $edad;
    }

    public function getId() {
        return $this->id;
    }
    public function getNombre() {
        return $this->nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getEdad() {
        return $this->edad;
    }

    // Métodos para modificar las propiedades, si es necesario
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setEdad($edad) {
        $this->edad = $edad;
    }
    public function getNombreCompleto() {
        return $this->nombre . ' ' . $this->apellido;
    }
    public function guardarEnBaseDeDatos() {
        try {
            //$config = include __DIR__ . '/../../config.php';
            $config = include __DIR__ . '/../config.php';

            // Establecer la conexión a la base de datos
            $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
            $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

            // Preparar la consulta SQL para la inserción
            $consultaSQL = "INSERT INTO alumnos (nombre, apellido, email, edad) VALUES (:nombre, :apellido, :email, :edad)";
            $sentencia = $conexion->prepare($consultaSQL);

            // Bind de los parámetros
            $sentencia->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
            $sentencia->bindParam(':apellido', $this->apellido, PDO::PARAM_STR);
            $sentencia->bindParam(':email', $this->email, PDO::PARAM_STR);
            $sentencia->bindParam(':edad', $this->edad, PDO::PARAM_INT);
       
            // Ejecutar la consulta
            $resultado = $sentencia->execute();

            // Verificar si la inserción tuvo éxito
            if ($resultado) {
                return true; // La inserción se realizó con éxito
            } else {
                return false; // La inserción falló
            }
        }catch (PDOException $error) {
                // Manejo de errores en caso de problemas con la base de datos
                // Registra el error en el registro de errores o muestra un mensaje de error detallado
                error_log("Error en la inserción de alumno: " . $error->getMessage());
                return false;
            }
    }
    /*
    public static function borrarDeBaseDeDatos($id) {
        try {
            $config = include __DIR__ . '/../config.php';


            echo 'Alumno.php: id usuario'.$id. '<br>';
            // Establecer la conexión a la base de datos
            $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
            $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

            if (!$conexion) {
                die("Error de conexión a la base de datos.");
            }

            // Preparar la consulta SQL para eliminar el alumno por su ID
            $consultaSQL = "DELETE FROM alumnos WHERE id = :id";
            $sentencia = $conexion->prepare($consultaSQL);

            echo 'a';
            // Bind; del parámetro
            $sentencia->bindParam(':id', $id, PDO::PARAM_INT);

            echo "Valor de \$id antes de ejecutar la consulta: $id<br>";
            echo 'b';
            echo "Consulta SQL preparada: " . $sentencia->queryString . "<br>";
            // Ejecutar la consulta
            $resultado = $sentencia->execute();
            
            // Verificar si la eliminación tuvo éxito
            if ($resultado) {
                return true; // La eliminación se realizó con éxito
            } else {
                echo "Error al eliminar el alumno: " . $sentencia->errorInfo()[2];
                return false; // La eliminación falló
            }
        } catch (PDOException $error) {
            // Manejo de errores en caso de problemas con la base de datos
            // Registra el error en el registro de errores o muestra un mensaje de error detallado

            error_log("Error al eliminar el alumno: " . $error->getMessage());
            return false;
        }
    }*/
    public static function borrarDeBaseDeDatos($id) {
        try {
            $config = include __DIR__ . '/../config.php';
    
            // Establecer la conexión a la base de datos
            $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
            $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    
            // Preparar la consulta SQL para eliminar el alumno por su ID
            $consultaSQL = "DELETE FROM alumnos WHERE id = :id";
            $sentencia = $conexion->prepare($consultaSQL);
    
            // Bind del parámetro
            $sentencia->bindParam(':id', $id, PDO::PARAM_INT);
    
            // Ejecutar la consulta
            $resultado = $sentencia->execute();
    
            // Verificar si la eliminación tuvo éxito
            if ($resultado) {
                return true; // La eliminación se realizó con éxito
            } else {
                return false; // La eliminación falló
            }
        } catch (PDOException $error) {
            // Manejo de errores en caso de problemas con la base de datos
            // Registra el error en el registro de errores o muestra un mensaje de error detallado
            error_log("Error al eliminar el alumno: " . $error->getMessage());
            return false;
        }
    }
    
    public function actualizarEnBaseDeDatos($id, $nombre, $apellido, $email, $edad) {
        try {
            $config = include __DIR__ . '/../config.php';

            // Establecer la conexión a la base de datos
            $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
            $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

            // Preparar la consulta SQL para la actualización
            $consultaSQL = "UPDATE alumnos SET
                nombre = :nombre,
                apellido = :apellido,
                email = :email,
                edad = :edad,
                updated_at = NOW()
                WHERE id = :id";
            $sentencia = $conexion->prepare($consultaSQL);

            // Bind de los parámetros
            $sentencia->bindParam(':id', $id, PDO::PARAM_INT);
            $sentencia->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $sentencia->bindParam(':apellido', $apellido, PDO::PARAM_STR);
            $sentencia->bindParam(':email', $email, PDO::PARAM_STR);
            $sentencia->bindParam(':edad', $edad, PDO::PARAM_INT);
       
            // Ejecutar la consulta
            $resultado = $sentencia->execute();

            // Verificar si la actualización tuvo éxito
            if ($resultado) {
                return true; // La actualización se realizó con éxito
            } else {
                return false; // La actualización falló
            }
        } catch (PDOException $error) {
            // Manejo de errores en caso de problemas con la base de datos
            // Registra el error en el registro de errores o muestra un mensaje de error detallado
            error_log("Error en la actualización del alumno: " . $error->getMessage());
            return false;
        }
    }
    public static function obtenerAlumnoPorId($idAlumno) {
        try {
            $config = include __DIR__ . '/../config.php';
            //__DIR__ . '/../../config.php'
            // Establecer la conexión a la base de datos
            $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
            $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    
            // Preparar la consulta SQL para obtener al alumno por su ID
            $consultaSQL = "SELECT * FROM alumnos WHERE id = :id";
            $sentencia = $conexion->prepare($consultaSQL);
            $sentencia->bindParam(':id', $idAlumno, PDO::PARAM_INT);
            $sentencia->execute();
    
            // Obtener los datos del alumno como un arreglo asociativo
            $alumno = $sentencia->fetch(PDO::FETCH_ASSOC);
    
            return $alumno;
        } catch (PDOException $error) {
            // Manejo de errores en caso de problemas con la base de datos
            // Registra el error en el registro de errores o muestra un mensaje de error detallado
            error_log("Error al obtener al alumno por ID: " . $error->getMessage());
            return null; // Retorna null en caso de error
        }
    }
    
}
/*
catch (PDOException $error) {
    // Manejo de errores en caso de problemas con la base de datos
    // Registra el error en el registro de errores o muestra un mensaje de error detallado
    error_log("Error en la inserción de alumno: " . $error->getMessage());
    return false;
}
*/
?>