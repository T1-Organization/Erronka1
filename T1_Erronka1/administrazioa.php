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

  //lista usuarios

  $consultaSQLUsuarios = "SELECT * FROM usuarios";
  $sentenciaUsuarios = $conexion->prepare($consultaSQLUsuarios);
  $sentenciaUsuarios->execute();

  $usuarios = $sentenciaUsuarios->fetchAll();

  $sql = "SELECT id, nombre, familia FROM cursos";
  $sentenciaCursos = $conexion->query($sql);
  $sentenciaCursos->execute();

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
      <a href="views/alumno/crear.php"  class="btn btn-primary mt-4">Crear alumno</a>
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
                  <a href="<?= 'views/alumno/borrar.php?id=' . escapar($fila["id"]) ?>">🗑️Borrar</a>
                  <a href="<?= 'views/alumno/editar.php?id=' . escapar($fila["id"]) ?>">✏️Editar</a>
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
<div class="container">
  <div class="row">
    <div class="col-md-12">
    <a href="formulario.php"  class="btn btn-primary mt-4">Crear nuevo usuario</a>
      <hr>
    </div>
  </div>
</div>
<!-- Agrega la tabla de usuarios después de la tabla de alumnos -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mt-3">Lista de usuarios</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre de Usuario</th>
                        <th>Administrador</th>
                        <!-- Agrega más columnas según tus necesidades -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($usuarios && $sentenciaUsuarios->rowCount() > 0) {
                        foreach ($usuarios as $filaUsuario) {
                            ?>
                            <tr>
                                <td><?php echo escapar($filaUsuario["id"]); ?></td>
                                <td><?php echo escapar($filaUsuario["usuario"]); ?></td>
                                <td><?php echo escapar($filaUsuario["administrador"]); ?></td>
                                <!-- Agrega más celdas según tus necesidades -->
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mt-3">Lista de Cursos</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Familia</th>
                        <!-- Agrega más columnas según tus necesidades -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                     if ($sentenciaCursos->rowCount() > 0) {
                      while ($row = $sentenciaCursos->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <tr>
                                <td><?php echo escapar($row["id"]); ?></td>
                                <td><?php echo escapar($row["nombre"]); ?></td>
                                <td><?php echo escapar($row["familia"]); ?></td>
                                <td><a href="inscribirse.php?id=<?php echo escapar($row["id"]); ?>" class="btn btn-primary">Inscribirse</a></td>
                                <!-- Agrega más celdas según tus necesidades -->
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php

   // Comprobar si se encontraron cursos
   /*if ($sentenciaCursos->rowCount() > 0) {
    echo '<h1>Lista de Cursos</h1>';
    echo '<ul>';
    while ($row = $sentenciaCursos->fetch(PDO::FETCH_ASSOC)) {
        echo '<li><a href="inscribirse.php?id=' . $row['id'] . '">' . $row['nombre'] . '</a></li>';
    }
    echo '</ul>';
} else {
    echo 'No se encontraron cursos.';
}*/
?>





<?php include "templates/footer.php"; ?>