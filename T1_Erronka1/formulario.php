
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

  <label for="alumno">Selecciona un Alumno:</label>
<select name="alumno" id="alumno" required>
  <?php
  // Conecta a la base de datos
  $config = include 'config.php';
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
  
  // Consulta SQL para obtener la lista de alumnos
  $consultaAlumnos = "SELECT id, nombre, apellido FROM alumnos";
  $resultadoAlumnos = $conexion->query($consultaAlumnos);
  
  // Recorre los resultados y crea opciones para cada alumno
  while ($alumno = $resultadoAlumnos->fetch(PDO::FETCH_ASSOC)) {
    echo '<option value="' . $alumno['id'] . '">' . $alumno['nombre'] . ' ' . $alumno['apellido'] . '</option>';
  }
  ?>
</select><br>
<input type="submit" name="submit" value="Crear Usuario">
</form>
</body>

</html>

