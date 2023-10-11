<?php
//session_start(); // Inicia la sesión
include 'funciones.php';
$config = include 'config.php';
csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}
include 'controller/UsuarioController.php';
?>
<?php include "templates/header.php"; ?>

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h2 class="mt-3">Crear Usuario</h2>
            <form method="post" action="crear_usuario.php">
                <div class="form-group">
                    <label for="usuario">Nombre de Usuario:</label>
                    <input type="text" id="usuario" name="usuario" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="contrasena">Contraseña:</label>
                    <input type="password" id="contrasena" name="contrasena" class="form-control" required>
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" id="administrador" name="administrador" class="form-check-input">
                    <label class="form-check-label" for="administrador">¿Es administrador?</label>
                </div>
                <div class="form-group">
                    <label for="alumnoId">Selecciona un Alumno:</label>
                    <select name="alumnoId" id="alumnoId" class="form-control" required>
                        <?php
                        // Aquí deberías obtener la lista de alumnos desde tu controlador
                        $usuariosController = new UsuarioController();
                        $alumnos = $usuariosController->listarAlumnos();

                        foreach ($alumnos as $alumno) {
                            echo '<option value="' . $alumno->getId() . '">' . $alumno->getNombreCompleto() . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <input type="hidden" name="csrf" value="<?php echo $_SESSION['csrf']; ?>">
                <button type="submit" name="submit" class="btn btn-primary">Crear Usuario</button>
            </form>
        </div>
    </div>
</div>
<?php include "templates/footer.php"; ?>



