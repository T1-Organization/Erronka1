<?php
require_once 'controller/CursoController.php';

// Verificar si el usuario está autenticado
session_start();

// Función para obtener el ID del alumno correspondiente al usuario
function obtenerIdAlumnoPorUsuario($usuarioId) {
    try {
        $config = include 'config.php';
        $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
        $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
        $consultaSQL = "SELECT id_alumno FROM usuarios WHERE id = :usuarioId";
        $sentencia = $conexion->prepare($consultaSQL);
        $sentencia->bindParam(':usuarioId', $usuarioId, PDO::PARAM_INT);
        $sentencia->execute();

        $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);

        if ($resultado && isset($resultado['id_alumno'])) {
            return $resultado['id_alumno'];
        } else {
            // No se encontró el ID del alumno para el usuario dado
            return null;
        }
    } catch (PDOException $error) {
        // Manejar errores de la base de datos aquí
        return null;
    }
}
function verificarExistenciaCurso($cursoId, $conexion) {
    try {
        // Realiza una consulta para verificar si el curso existe en la base de datos
        $consultaSQL = "SELECT COUNT(*) FROM cursos WHERE id = :cursoId";
        $sentencia = $conexion->prepare($consultaSQL);
        $sentencia->bindParam(':cursoId', $cursoId, PDO::PARAM_INT);
        $sentencia->execute();

        // Obtiene el resultado de la consulta
        $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);

        // Si el resultado es mayor que cero, el curso existe
        return ($resultado && intval($resultado['COUNT(*)']) > 0);
    } catch (PDOException $error) {
        // Manejar errores de la base de datos aquí
        return false;
    }
}

function verificarUsuarioInscritoEnCurso($alumnoId, $cursoId, $conexion) {
    try {
        // Realiza una consulta para verificar si el usuario está inscrito en el curso
        $consultaSQL = "SELECT COUNT(*) FROM inscripcion WHERE id_alumno = :alumnoId AND id_curso = :cursoId";
        $sentencia = $conexion->prepare($consultaSQL);
        $sentencia->bindParam(':alumnoId', $alumnoId, PDO::PARAM_INT);
        $sentencia->bindParam(':cursoId', $cursoId, PDO::PARAM_INT);
        $sentencia->execute();

        // Obtiene el resultado de la consulta
        $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);

        // Si el resultado es mayor que cero, el usuario está inscrito en el curso
        return ($resultado && intval($resultado['COUNT(*)']) > 0);
    } catch (PDOException $error) {
        // Manejar errores de la base de datos aquí
        return false;
    }
}
if (isset($_SESSION['usuario_id'])) {
    // Obtener el ID del usuario autenticado
    echo 'se ejecuta el if';
    $usuarioId = $_SESSION['usuario_id'];

    // Obtener el ID del alumno correspondiente al usuario autenticado
    $alumnoId = obtenerIdAlumnoPorUsuario($usuarioId);

    // Verificar si se ha pasado el ID del curso en la URL
    if (isset($_POST['id'])) {
        echo 'if post id se ejecuta';
        $cursoId = $_POST['id'];
        $config = include 'config.php';
        $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
        $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);    
        try {
            // Validar si el curso existe y si el usuario no está inscrito previamente en él
            // Implementa las funciones verificarExistenciaCurso y verificarUsuarioInscritoEnCurso según tu base de datos

            // Implementa la función verificarExistenciaCurso que debe verificar si el curso existe en la base de datos
            $cursoExiste = verificarExistenciaCurso($cursoId, $conexion); 

            // Implementa la función verificarUsuarioInscritoEnCurso que debe verificar si el usuario ya está inscrito en el curso
            $usuarioInscrito = verificarUsuarioInscritoEnCurso($alumnoId, $cursoId, $conexion); 

            if ($cursoExiste && !$usuarioInscrito) {
                // Crear una instancia del controlador de cursos
                $cursoController = new CursoController();

                // Realizar la inscripción llamando al método del controlador
                $cursoController->inscribirseEnCurso($cursoId, $alumnoId);

                // Después de realizar la inscripción, puedes redirigir al usuario a una página de confirmación o a la lista de cursos
                // header('Location: lista_cursos.php'); // Cambia "lista_cursos.php" al nombre de tu página de lista de cursos
                exit();
            } else {
                // Si el curso no existe o el usuario ya está inscrito, redirigir a una página de error o mostrar un mensaje de error
                // header('Location: error.php'); // Cambia "error.php" al nombre de tu página de error
                exit();
            }
        } catch (PDOException $error) {
            // Manejar excepciones de PDO aquí
            // Puedes redirigir o mostrar un mensaje de error
            // header('Location: error.php'); // Cambia "error.php" al nombre de tu página de error
            exit();
        }
    } else {
        // Si no se proporcionó un ID de curso válido en la URL, mostrar un mensaje de error o redirigir a la lista de cursos
        // header('Location: lista_cursos.php'); // Cambia "lista_cursos.php" al nombre de tu página de lista de cursos
        exit();
    }
}



?>



