<?php
include 'funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

$error = false;
$config = include 'config.php';

$usuarios = []; // Define un arreglo para almacenar los usuarios (debes obtener estos datos de tu controlador o modelo)

try {
    // ... Tu código anterior ...
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    // Consulta SQL para obtener los usuarios
    $consultaSQLUsuarios = "SELECT * FROM usuarios";
    $sentenciaUsuarios = $conexion->prepare($consultaSQLUsuarios);
    $sentenciaUsuarios->execute();

    $usuarios = $sentenciaUsuarios->fetchAll();
} catch (PDOException $error) {
    $error = $error->getMessage();
}

// ... Tu código anterior ...

?>

<!-- ... Tu código HTML anterior ... -->

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

<!-- ... Tu código HTML posterior ... -->

