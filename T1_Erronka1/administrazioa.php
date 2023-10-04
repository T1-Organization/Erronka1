<?php
include 'funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

$error = false;
$config = include 'config.php';

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  if (isset($_POST['apellido'])) {
    $consultaSQL = "SELECT * FROM alumnos WHERE apellido LIKE '%" . $_POST['apellido'] . "%'";
  } else {
    $consultaSQL = "SELECT * FROM alumnos";
  }

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $alumnos = $sentencia->fetchAll();

} catch(PDOException $error) {
  $error= $error->getMessage();
}

$titulo = isset($_POST['apellido']) ? 'Lista de alumnos (' . $_POST['apellido'] . ')' : 'Lista de alumnos';
?>

<?php include "templates/header.php"; ?>

<?php
if ($error) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger" role="alert">
          <?= $error ?>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>
<?php
if (isset($_SESSION['usuario_id'])) {
  $nombreUsuario = $_SESSION['nombre_usuario'];
  $administradorUsuario = $_SESSION['administrador'];
  echo $nombreUsuario;
  /*if ($administradorUsuario) {
    // Mostrar contenido específico para administradores
    //echo "Administrador, $nombreUsuario";
    echo  $nombreUsuario;
  } else {
    // Mostrar contenido para usuarios no administradores 
    //echo "Bienvenido, $nombreUsuario";
  }*/
  echo '<br>';
  echo ' <a href="logout.php">Cerrar sesión</a>';
} else {
  echo "Bienvenido al sitio web"; 
  echo ' <a href="login.php">Iniciar sesión</a>';
}
/*
if (isset($_SESSION['administrador']) && $_SESSION['administrador']) {
  // Mostrar contenido específico para administradores
  echo "<p>Bienvenido, administrador.</p>";
  $nombreUsuario = $_SESSION['nombre_usuario'];
  echo "Bienvenido, $nombreUsuario";
  echo ' <a href="logout.php">Cerrar sesión</a>';
  // Coloca aquí el contenido adicional para administradores
} else {
  // Mostrar contenido para usuarios no administradores
  echo "<p>Bienvenido, usuario normal.</p>";
  $nombreUsuario = $_SESSION['nombre_usuario'];
  echo "Bienvenido, $nombreUsuario";
  echo ' <a href="logout.php">Cerrar sesión</a>';
  // Coloca aquí el contenido adicional para usuarios normales
}

*/

?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <a href="crear.php"  class="btn btn-primary mt-4">Crear alumno</a>
      <hr>
      <form method="post" class="form-inline">
        <div class="form-group mr-3">
          <input type="text" id="apellido" name="apellido" placeholder="Buscar por apellido" class="form-control">
        </div>
        <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
        <button type="submit" name="submit" class="btn btn-primary">Ver resultados</button>
      </form>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="mt-3"><?= $titulo ?></h2>
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Email</th>
            <th>Edad</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($alumnos && $sentencia->rowCount() > 0) {
            foreach ($alumnos as $fila) {
              ?>
              <tr>
                <td><?php echo escapar($fila["id"]); ?></td>
                <td><?php echo escapar($fila["nombre"]); ?></td>
                <td><?php echo escapar($fila["apellido"]); ?></td>
                <td><?php echo escapar($fila["email"]); ?></td>
                <td><?php echo escapar($fila["edad"]); ?></td>
                <td>
                  <a href="<?= 'borrar.php?id=' . escapar($fila["id"]) ?>">🗑️Borrar</a>
                  <a href="<?= 'editar.php?id=' . escapar($fila["id"]) ?>">✏️Editar</a>
                </td>
              </tr>
              <?php
            }
          }
          ?>
        <tbody>
      </table>
    </div>
  </div>
</div>
<a href="formulario.php">Crear nuevo usuario</a>

<?php include "templates/footer.php"; ?>