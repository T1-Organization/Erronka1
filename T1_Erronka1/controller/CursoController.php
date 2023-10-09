<?php

class CursoController {
    // ... otros métodos ...

    public function inscribirseEnCurso($cursoId, $usuarioId) {
        echo ' entra en controller';
        $config = include __DIR__ . '/../config.php'; 
        $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
        $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);


        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inscribirse'])) {
            // Asegúrate de tener una instancia válida de PDO en $conexion
        
            $usuarioId = $_SESSION['usuario_id']; // Obtén el ID del usuario autenticado
            $cursoId = $_POST['curso_id']; // Obtén el ID del curso desde el formulario
        
            // Asegúrate de que el usuario no esté ya inscrito en el curso (puedes hacer una verificación aquí)
        
            // Llama a la función para inscribir al usuario en el curso
            $inscripcion = new Inscripcion(null, $usuarioId, $cursoId); // El parámetro $id se pasa como null o se puede omitir
            echo $inscripcion;
            $exito = $inscripcion->inscribirseEnCurso($conexion);
        
            if ($exito) {
                // El usuario se ha inscrito correctamente
                // Puedes redirigir o mostrar un mensaje de éxito
                header('Location: cursos.php');
                exit();
            } else {
                // Hubo un error al inscribir al usuario
                // Puedes redirigir o mostrar un mensaje de error
                header('Location: cursos.php?error=1');
                exit();
            }
        }else{
            echo'error controller en inscribirse curso ';

        }
    }
}

?>