<?php

require_once __DIR__ .  '/../model/Usuario.php';
include_once __DIR__ . '/../model/Alumno.php';
class UsuarioController {
    
    public static function crearUsuario($usuario) {
        // Validar y procesar datos según tus reglas de negocio

        // Crear una instancia de la clase Usuario
        //$usuario = new Usuario( $nombreUsuario, $contrasena, $administrador, $alumnoId);

        // Guardar el usuario en la base de datos
        $guardado = $usuario->guardarEnBaseDeDatos();

        return $guardado;
    }
    
    public static function listarAlumnos() {
        try {
            // Conecta a la base de datos
            $config = include __DIR__ . '/../config.php'; // Ajusta la ruta según tu estructura
            $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
            $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    
            // Consulta SQL para obtener la lista de alumnos
            $consultaAlumnos = "SELECT id,nombre, apellido, email, edad FROM alumnos";
            $resultadoAlumnos = $conexion->query($consultaAlumnos);
    
            $alumnos = array(); // Inicializa un arreglo para almacenar los objetos Alumno
    
            // Recorre los resultados y crea objetos Alumno
            while ($fila = $resultadoAlumnos->fetch(PDO::FETCH_ASSOC)) {
                var_dump($fila);
                echo '<br>';

                $alumno = new Alumno($fila['id'],$fila['nombre'], $fila['apellido'], $fila['email'], $fila['edad']);
                $alumnos[] = $alumno;
            }

            $alumno = new Alumno( 25,"Nombre", "Apellido", "email@example.com",25);
            echo "getID prueba".$alumno->getId();

                // Imprime el array de alumnos para depuración
            echo '<pre>';
            print_r($alumnos);
            echo '</pre>';
            return $alumnos;
        } catch (PDOException $error) {
            // Manejo de errores en caso de problemas con la base de datos
            // Registra el error en el registro de errores o muestra un mensaje de error detallado
            error_log("Error al listar alumnos: " . $error->getMessage());
            return array(); // Retorna un arreglo vacío en caso de error
        }
    }
    
    
    

    public static function obtenerUsuarioPorId($id) {
        // Obtener un usuario por su ID desde la base de datos (implementa esta función en Usuario.php)
        $usuario = Usuario::obtenerPorId($id); 

        return $usuario;
    }

    public static function editarUsuario($id, $nombreUsuario, $contrasena, $administrador, $alumnoId) {
        // Validar y procesar datos según tus reglas de negocio

        // Obtener el usuario existente por su ID
        $usuarioExistente = Usuario::obtenerPorId($id);

        if (!$usuarioExistente) {
            return false; // El usuario no existe
        }

        // Actualizar los datos del usuario existente
        $usuarioExistente->setNombreUsuario($nombreUsuario);
        $usuarioExistente->setContrasena($contrasena);
        $usuarioExistente->setAdministrador($administrador);
        $usuarioExistente->setAlumnoId($alumnoId);

        // Guardar los cambios en la base de datos
        $actualizado = $usuarioExistente->guardarEnBaseDeDatos();

        return $actualizado;
    }

    public static function borrarUsuario($id) {
        // Obtener el usuario existente por su ID
        $usuarioExistente = Usuario::obtenerPorId($id);

        if (!$usuarioExistente) {
            return false; // El usuario no existe
        }

        // Eliminar el usuario de la base de datos
        $eliminado = $usuarioExistente->borrarDeBaseDeDatos($id);

        return $eliminado;
    }
}

?>
