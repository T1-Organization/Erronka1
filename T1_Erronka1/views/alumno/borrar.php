<?php
include '../../funciones.php';
include '../../model/Alumno.php';
include '../../controller/AlumnoController.php';



$resultado = [
    'error' => false,
    'mensaje' => ''
];

try {
    $id = $_GET['id'];

    // Crear una instancia del controlador de alumnos
    $controladorAlumno = new AlumnoController();

    // Intentar eliminar al alumno
    if ($controladorAlumno->borrarAlumno($id)) {
        header('location: /Ekoizpen Seguruan Jartzea/1.Ebaluaketa/Adibidea_erronka1/tutorial-crud-php-main/administrazioa.php');
    } else {
        $resultado['error'] = true;
        $resultado['mensaje'] = 'Hubo un error al eliminar el alumno.';
    }
} catch (Exception $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
}
?>
<?php include '../../templates/header.php'; ?>

<div class="container mt-2">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-<?= $resultado['error'] ? 'danger' : 'success' ?>" role="alert">
                <?= $resultado['mensaje'] ?>
            </div>
        </div>
    </div>
</div>

<?php include '../../templates/header.php'; ?>





