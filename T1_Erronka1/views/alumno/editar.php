<?php
// Aquí incluye tus configuraciones, clases y funciones necesarias
include '../../funciones.php';
include '../../model/Alumno.php';
include '../../controller/AlumnoController.php';
csrf(); // Asegúrate de tener la protección CSRF habilitada

$resultado = [
    'error' => false,
    'mensaje' => ''
];

if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
    die(); // Si la protección CSRF falla, puedes manejarlo aquí
}

if (isset($_POST['submit'])) {
    try {
        $controladorAlumno = new AlumnoController();

        // Obtener los datos del formulario
        $id = $_GET['id'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $edad = $_POST['edad'];

        // Intentar actualizar los datos del alumno
        $controladorAlumno->editarAlumno($id, $nombre, $apellido, $email, $edad);

        // Verificar si la edición tuvo éxito
        $resultado['mensaje'] = 'El alumno ha sido actualizado con éxito';
    } catch (PDOException $error) {
        $resultado['error'] = true;
        $resultado['mensaje'] = $error->getMessage();
    }
}

// Obtener el alumno para cargar sus datos en el formulario
$idAlumno = $_GET['id']; // Asegúrate de validar y sanitizar esta entrada
$alumno =Alumno::obtenerAlumnoPorId($idAlumno); // Implementa esta función según tu lógica

// Ahora puedes mostrar el formulario y los mensajes en la misma página
?>

<?php include '../../templates/header.php'; ?>

<?php if ($resultado['error']) : ?>
    <div class="container mt-2">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
                    <?= $resultado['mensaje'] ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mt-4">Editando el alumno <?= escapar($alumno['nombre']) . ' ' . escapar($alumno['apellido'])  ?></h2>
            <hr>
            <form method="post">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" value="<?= escapar($alumno['nombre']) ?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="apellido">Apellido</label>
                    <input type="text" name="apellido" id="apellido" value="<?= escapar($alumno['apellido']) ?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?= escapar($alumno['email']) ?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="edad">Edad</label>
                    <input type="text" name="edad" id="edad" value="<?= escapar($alumno['edad']) ?>" class="form-control">
                </div>
                <div class="form-group">
                    <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
                    <input type="submit" name="submit" class="btn btn-primary" value="Actualizar">
                    <a class="btn btn-primary" href="administrazioa.php">Regresar al inicio</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../../templates/header.php'; ?>
