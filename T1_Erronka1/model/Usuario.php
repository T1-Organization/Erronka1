<?php 
class Usuario {
    private $id;
    private $nombreUsuario;
    private $contrasena;
    private $administrador;
    private $alumnoId;

    public function __construct( $nombreUsuario, $contrasena, $administrador, $alumnoId) {
    
        $this->nombreUsuario = $nombreUsuario;
        $this->contrasena = $contrasena;
        $this->administrador = $administrador;
        $this->alumnoId = $alumnoId;
    }

    // Métodos para acceder a las propiedades
    public function getId() {
        return $this->id;
    }

    public function getNombreUsuario() {
        return $this->nombreUsuario;
    }

    public function getContrasena() {
        return $this->contrasena;
    }

    public function esAdministrador() {
        return $this->administrador;
    }

    public function getAlumnoId() {
        return $this->alumnoId;
    }

    // Métodos para modificar las propiedades, si es necesario
    public function setNombreUsuario($nombreUsuario) {
        $this->nombreUsuario = $nombreUsuario;
    }

    public function setContrasena($contrasena) {
        $this->contrasena = $contrasena;
    }

    public function setAdministrador($administrador) {
        $this->administrador = $administrador;
    }

    public function setAlumnoId($alumnoId) {
        $this->alumnoId = $alumnoId;
    }

    // Otros métodos relacionados con los usuarios
       // Propiedades y métodos existentes

    // Método para eliminar un usuario de la base de datos por su ID
    public static function borrarDeBaseDeDatos($id) {
        try {
            $config = include __DIR__ . '/../config.php';

            // Establecer la conexión a la base de datos
            $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
            $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

            // Preparar la consulta SQL para eliminar el usuario por su ID
            $consultaSQL = "DELETE FROM usuarios WHERE id = :id";
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
            error_log("Error al eliminar el usuario: " . $error->getMessage());
            return false;
        }
    }
    public function guardarEnBaseDeDatos() {
        echo "A";
        try {
            $config = include __DIR__ . '/../config.php';

            // Establecer la conexión a la base de datos
            $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
            $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
            // Cifrar la contraseña
            $contrasenaCifrada = password_hash($this->contrasena, PASSWORD_DEFAULT);

            // Preparar la consulta SQL para insertar el usuario
            $consultaSQL = "INSERT INTO usuarios (usuario, contraseña, administrador, id_alumno) VALUES (:nombreUsuario, :contrasena, :administrador, :alumnoId)";
            $sentencia = $conexion->prepare($consultaSQL);

            // Bind de los parámetros
            $sentencia->bindParam(':nombreUsuario', $this->nombreUsuario, PDO::PARAM_STR);
            $sentencia->bindParam(':contrasena', $contrasenaCifrada, PDO::PARAM_STR);
            $sentencia->bindParam(':administrador', $this->administrador, PDO::PARAM_INT);
            $sentencia->bindParam(':alumnoId', $this->alumnoId, PDO::PARAM_INT);

            // Ejecutar la consulta
            $resultado = $sentencia->execute();
            echo" echo despues sentencia";
            // Verificar si la inserción tuvo éxito
            if ($resultado) {
                return true; // La inserción se realizó con éxito
            } else {
                return false; // La inserción falló
            }
        } catch (PDOException $error) {
            // Manejo de errores en caso de problemas con la base de datos
            // Registra el error en el registro de errores o muestra un mensaje de error detallado
            error_log("Error al insertar el usuario: " . $error->getMessage());
            return false;
        }
    }

    public static function obtenerPorNombreUsuario($nombreUsuario) {
        try {
            // Conectar a la base de datos y ejecutar la consulta para obtener el usuario por nombre de usuario
            $config = include __DIR__ . '/../config.php';
            $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
            $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    
            $consulta = "SELECT * FROM usuarios WHERE nombreUsuario = :nombreUsuario";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->bindParam(':nombreUsuario', $nombreUsuario, PDO::PARAM_STR);
            $sentencia->execute();
    
            // Obtener el resultado como un objeto de la clase Usuario
            $usuario = $sentencia->fetchObject('Usuario');
    
            return $usuario;
        } catch (PDOException $error) {
            // Manejo de errores en caso de problemas con la base de datos
            // Registra el error en el registro de errores o muestra un mensaje de error detallado
            error_log("Error al obtener usuario por nombre de usuario: " . $error->getMessage());
            return null; // Retorna null en caso de error
        }
    }
    public static function obtenerPorId($id) {
        try {
            // Conectar a la base de datos y ejecutar la consulta para obtener el usuario por ID
            $config = include __DIR__ . '/../config.php';
            $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
            $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    
            $consulta = "SELECT * FROM usuarios WHERE id = :id";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->bindParam(':id', $id, PDO::PARAM_INT);
            $sentencia->execute();
    
            // Obtener el resultado como un objeto de la clase Usuario
            $usuario = $sentencia->fetchObject('Usuario');
    
            return $usuario;
        } catch (PDOException $error) {
            // Manejo de errores en caso de problemas con la base de datos
            // Registra el error en el registro de errores o muestra un mensaje de error detallado
            error_log("Error al obtener usuario por ID: " . $error->getMessage());
            return null; // Retorna null en caso de error
        }
    }

}

?>