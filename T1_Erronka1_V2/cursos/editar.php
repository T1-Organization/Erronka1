<?php
include '../funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

$config = include '../config.php';

$resultado = [
  'error' => false,
  'mensaje' => ''
];

if (!isset($_GET['id'])) {
  $resultado['error'] = true;
  $resultado['mensaje'] = 'El curso no existe';
}

if (isset($_POST['submit'])) {
  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $curso = [
      "id"        => $_GET['id'],
      "nombre"    => $_POST['nombre'],
      "familia"  => $_POST['familia'],
    ];
    
    $consultaSQL = "UPDATE cursos SET
        nombre = :nombre,
        familia = :familia,
        updated_at = NOW()
        WHERE id = :id";
    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($curso);

  } catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    
  $id = $_GET['id'];
  $consultaSQL = "SELECT * FROM cursos WHERE id =" . $id;

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $curso = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$curso) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'No se ha encontrado el curso';
  }

} catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}
?>

<?php require "../templates/header.php"; ?>

<?php
if ($resultado['error']) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger" role="alert">
          <?= $resultado['mensaje'] ?>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php
if (isset($_POST['submit']) && !$resultado['error']) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-success" role="alert">
          El curso ha sido actualizado correctamente
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php
if (isset($curso) && $curso) {
  ?>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="mt-4">Editando el curso <?= escapar($curso['nombre']) . ' ' . escapar($curso['familia'])  ?></h2>
        <hr>
        <form method="post">
          <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="<?= escapar($curso['nombre']) ?>" class="form-control">
          </div>
          <div class="form-group">
            <label for="familia">Familia</label>
            <input type="text" name="familia" id="familia" value="<?= escapar($curso['familia']) ?>" class="form-control">
          </div>
          <div class="form-group">
            <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
            <input type="submit" name="submit" class="btn btn-primary" value="Actualizar">
            <a class="btn btn-primary" href="cursos.php">Regresar al inicio</a>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php require "../templates/footer.php"; ?>