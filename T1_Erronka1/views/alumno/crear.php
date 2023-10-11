<?php
// Incluir las clases y funciones necesarias
include '../../funciones.php';
include '../../model/Alumno.php';
include '../../controller/AlumnoController.php';

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar el token CSRF
    csrf();

    $resultado = [
        'error' => false,
        'mensaje' => ''
    ];

    try {
        // Crear una instancia del controlador de alumnos
        $controladorAlumno = new AlumnoController();

        // Obtener datos del formulario
        $id = "";
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $edad = $_POST['edad'];

   

        // Validar los datos ingresados
        if (empty($nombre) || empty($apellido) || empty($email) || empty($edad)) {
            throw new Exception("Todos los campos son obligatorios.");
        }

        // Crear una instancia de la clase Alumno
        $alumno = new Alumno($id, $nombre, $apellido, $email, $edad);
       
        $nombre = $alumno->getNombre();
        $apellido = $alumno->getApellido();
        $email = $alumno->getEmail();
        $edad = $alumno->getEdad();

        /*echo "Nombre: " . $nombre . "<br>";
        echo "Apellido: " . $apellido . "<br>";
        echo "Email: " . $email . "<br>";
        echo "Edad: " . $edad . "<br>";*/

        // Agregar el alumno a la base de datos
        if ($controladorAlumno->agregarAlumno($alumno)) {
            $resultado['mensaje'] = 'El alumno ' . escapar($nombre) . ' ha sido agregado con éxito.';
        } else {
            $resultado['error'] = true;
            $resultado['mensaje'] = 'Error al crear el alumno.';
        }
    } catch (Exception $error) {
        $resultado['error'] = true;
        $resultado['mensaje'] = $error->getMessage();
    }
}
?>

<?php include '../../templates/header.php'; ?>

<?php
if (isset($resultado)) {
?>
 
<?php
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mt-4">Crea un alumno</h2>
            <hr>
            <form method="post">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control">
                </div>
                <div class="form-group">
                    <label for="apellido">Apellido</label>
                    <input type="text" name="apellido" id="apellido" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="edad">Edad</label>
                    <input type="text" name="edad" id="edad" class="form-control">
                </div>
                <div class="form-group">
                    <input name="csrf" type="hidden" value="<?= escapar($_SESSION['csrf']) ?>">
                    <input type="submit" name="submit" class="btn btn-primary" value="Enviar">
                    <a class="btn btn-primary" href="administrazioa.php">Regresar al inicio</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include '../../templates/header.php'; ?>
