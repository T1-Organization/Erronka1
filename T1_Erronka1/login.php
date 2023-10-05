<?php
include 'funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

$error = false;
$config = include 'config.php';
?>

<html>
<body>
<form method="post" action="procesar_login.php">
  <div class="form-group">
    <label for="usuario">Nombre de Usuario:</label>
    <input type="text" id="usuario" name="usuario" class="form-control" required>
  </div>
  <div class="form-group">
    <label for="contrasena">Contraseña:</label>
    <input type="password" id="contrasena" name="contrasena" class="form-control" required>
  </div>
  <input type="hidden" name="csrf" value="<?php echo escapar($_SESSION['csrf']); ?>">
  <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
</form>
</body>
</html>
