<?php
include 'funciones.php';
require_once 'controller/CursoController.php';
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
if (isset($_SESSION['usuario_id']) && $_SESSION['administrador']) {
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
  echo '<br>';
  echo ' <a href="logout.php">Cerrar sesión</a>';
} else {
  echo "Bienvenido al sitio web"; 
  echo ' <a href="login.php">Iniciar sesión</a>';
}


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
                                <td>
                                    <form action="eliminar_usuario.php" method="POST">
                                        <input type="hidden" name="id_usuario" value="<?php echo escapar($filaUsuario["id"]); ?>">
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?')">Eliminar</button>
                                    </form>
                                </td>
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
                              <?php
                              if (isset($_SESSION['usuario_id'])){
                              ?>
                                <td>
                                <form method="post" action="inscribirse.php">
                                  <input type="hidden" name="id" value="<?php echo escapar($row["id"]); ?>">
                                  <button type="submit" class="btn btn-primary">Inscribirse</button>
                                </form>
                              </td>
                              <?php
                                }
                              ?>
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
// Obtén las inscripciones
$cursoController = new CursoController();
$inscripciones = $cursoController->obtenerInscripciones();
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mt-3">Tabla de Inscripciones</h2>
            <table class="table">
                <thead >
                    <tr>
                        <th>ID</th>
                        <th>Curso</th>
                        <th>Usuario</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($inscripciones as $inscripcion): ?>
                        <tr>
                            <td><?php echo $inscripcion['id']; ?></td>
                            <td><?php echo $inscripcion['curso']; ?></td>
                            <td><?php echo $inscripcion['usuario']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<?php

}else{
  header('Location: index.php');
}
?>

<?php include "templates/footer.php"; ?>