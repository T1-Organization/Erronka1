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
<html>
<body>
<form method="post" action="crear_usuario.php">
  <label for="usuario">Nombre de usuario:</label>
  <input type="text" id="usuario" name="usuario" required><br>

  <label for="contrasena">Contraseña:</label>
  <input type="password" id="contrasena" name="contrasena" required><br>

  <label for="administrador">¿Es administrador?</label>
  <input type="checkbox" id="administrador" name="administrador"><br>
 <input type="hidden" name="csrf" value="<?php echo $_SESSION['csrf']; ?>"><br>
  <label for="alumnoId">Selecciona un Alumno:</label>
        <select name="alumnoId" id="alumnoId" required>
            <?php
            // Aquí deberías obtener la lista de alumnos desde tu controlador
            $usuariosController = new UsuarioController();
            $alumnos = $usuariosController->listarAlumnos();

            foreach ($alumnos as $alumno) {
                //echo '<option value="' . $alumno->getId() . '">' . $alumno->getNombreCompleto() ."-". $alumno->getId() .'</option>';
                 echo '<option value="' . $alumno->getId() . '">' . $alumno->getNombreCompleto().'</option>';
            }
            ?>
        </select><br>
<input type="submit" name="submit" value="Crear Usuario">
</form>
</body>

</html>

