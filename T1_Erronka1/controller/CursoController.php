<?php
include_once __DIR__ . '/../model/Inscripcion.php';
class CursoController {
    // ... otros métodos ...

    public function inscribirseEnCurso($cursoId, $usuarioId) {
        $config = include __DIR__ . '/../config.php'; 
        $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
        
        try {
            $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
        
                // Asegúrate de tener una instancia válida de PDO en $conexion
                $usuarioId = $_SESSION['usuario_id']; // Obtén el ID del usuario autenticado
                $cursoId = $_POST['id']; // Obtén el ID del curso desde el formulario
                
                // Asegúrate de que el usuario no esté ya inscrito en el curso (puedes hacer una verificación aquí)
                
                // Llama a la función para inscribir al usuario en el curso
                $inscripcion = new Inscripcion(null, $usuarioId, $cursoId); // El parámetro $id se pasa como null o se puede omitir
                $exito = $inscripcion->inscribirse($conexion);
                
                if ($exito) {
                    // El usuario se ha inscrito correctamente
                    // Puedes redirigir o mostrar un mensaje de éxito
                    //header('Location: cursos.php');
                    exit();
                } else {
                    // Hubo un error al inscribir al usuario
                    // Puedes redirigir o mostrar un mensaje de error
                    //header('Location: cursos.php?error=1');
                    exit();
                }
           
        } catch (PDOException $e) {
            echo 'Error en la conexión a la base de datos: ' . $e->getMessage();
        }
    }

    public function obtenerInscripciones() {
        try {
            $config = include __DIR__ . '/../config.php'; // Ruta a tu archivo de configuración de base de datos
            $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
            $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    
            // Consulta SQL para obtener las inscripciones
            $consultaSQL = "SELECT inscripcion.id, cursos.nombre AS curso, usuario.usuario AS usuario FROM inscripcion AS inscripcion INNER JOIN cursos AS cursos ON inscripcion.id_curso = cursos.id INNER JOIN usuarios AS usuario ON inscripcion.id_usuario = usuario.id;";
    
            $resultado = $conexion->query($consultaSQL);
    
            $inscripciones = array();
    
            while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
                $inscripciones[] = $fila;
            }
    
            return $inscripciones;
        } catch (PDOException $error) {
            // Manejo de errores en caso de problemas con la base de datos
            // Registra el error en el registro de errores o muestra un mensaje de error detallado
            error_log("Error al obtener inscripciones: " . $error->getMessage());
            return array(); // Retorna un arreglo vacío en caso de error
        }
    }
    
    
}

?>