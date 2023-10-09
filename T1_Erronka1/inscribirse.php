<?php
require_once 'controller/CursoController.php';

// Verificar si el usuario está autenticado
session_start();
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

if (isset($_SESSION['usuario_id'])) {
    // Obtener el ID del usuario autenticado
    $usuarioId = $_SESSION['usuario_id'];

    // Supongamos que tienes una función para obtener el ID del alumno correspondiente a este usuario
    $alumnoId = obtenerIdAlumnoPorUsuario($usuarioId); // Implementa esta función según tu base de datos

    // Verificar si se ha pasado el ID del curso en la URL
    if (isset($_GET['id'])) {
        $cursoId = $_GET['id'];

        // Crear una instancia del controlador de cursos
        $cursoController = new CursoController();

        echo 'cursom id'.$cursoId.'<br>';
        echo 'alumno id'.$alumnoId.'<br>';
        // Realizar la inscripción llamando al método del controlador
        $cursoController->inscribirseEnCurso($cursoId, $alumnoId);

        // Después de realizar la inscripción, puedes redirigir al usuario a una página de confirmación o a la lista de cursos
       // header('Location: lista_cursos.php'); // Cambia "lista_cursos.php" al nombre de tu página de lista de cursos
        exit();
    } else {
        // Si no se proporcionó un ID de curso válido en la URL, mostrar un mensaje de error o redirigir a la lista de cursos
       // header('Location: lista_cursos.php'); // Cambia "lista_cursos.php" al nombre de tu página de lista de cursos
        exit();
    }
} else {
    // Si el usuario no está autenticado, redirigirlo a la página de inicio de sesión u otra página apropiada
    //header('Location: login.php'); // Cambia "login.php" al nombre de tu página de inicio de sesión
    exit();
}
?>


