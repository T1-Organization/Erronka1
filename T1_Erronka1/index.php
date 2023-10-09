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

    $sql = "SELECT id, nombre, familia FROM cursos";
    $sentenciaCursos = $conexion->query($sql);
    $sentenciaCursos->execute();
  
    
} catch(PDOException $error) {
    $error= $error->getMessage();
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
<?php include "templates/header.php"; ?>
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


<?php include "templates/footer.php"; ?>