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
  
    if (isset($_POST['nombre'])) {
      $consultaSQL = "SELECT * FROM cursos WHERE nombre LIKE '%" . $_POST['nombre'] . "%'";
    } else {
      $consultaSQL = "SELECT * FROM cursos";
    }
  
    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute();
  
    $cursos = $sentencia->fetchAll();
  
  } catch(PDOException $error) {
    $error= $error->getMessage();
  }

  $titulo = isset($_POST['nombre']) ? 'Lista de cursos (' . $_POST['nombre'] . ')' : 'Lista de cursos';
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

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <a href="login.php"><img src="img/login.png" alt="" style="float: right; margin-top: 20px; width: 50px;"></a>
      <hr style="margin-top: 90px">
      <form method="post" class="form-inline">
        <div class="form-group mr-3">
          <input type="text" id="nombre" name="nombre" placeholder="Buscar por nombre" class="form-control">
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
            <th>Familia</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($cursos && $sentencia->rowCount() > 0) {
            foreach ($cursos as $fila) {
              ?>
              <tr>
                <td><?php echo escapar($fila["id"]); ?></td>
                <td><?php echo escapar($fila["nombre"]); ?></td>
                <td><?php echo escapar($fila["familia"]); ?></td>
                <td>
                  <a href="inscribirse.php"><button type="submit" name="submit" class="btn btn-primary">Inscribirse</button></a>
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

<?php include "templates/footer.php"; ?>