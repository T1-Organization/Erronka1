<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Crear Usuario</title>
</head>
<body>

<?php

include 'funciones.php';

csrf();

echo $_SESSION['csrf'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  echo "A";

  
  // Resto del código...
  
  // Validar y filtrar los datos ingresados
  $usuario = filter_var($_POST['usuario'], FILTER_UNSAFE_RAW);
  $contrasena = $_POST['contrasena'];
  $es_administrador = isset($_POST['administrador']) ? 1 : 0;

  // Generar un hash seguro de la contraseña
  $hash_contrasena = password_hash($contrasena, PASSWORD_DEFAULT);

  // Realizar la inserción en la base de datos
  try {
    $config = include 'config.php';
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $consultaSQL = "INSERT INTO usuarios (usuario, contraseña, administrador) VALUES (:usuario, :contrasena, :administrador)";
    echo $consultaSQL;
    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->bindParam(':usuario', $usuario, PDO::PARAM_STR);
    $sentencia->bindParam(':contrasena', $hash_contrasena, PDO::PARAM_STR);
    $sentencia->bindParam(':administrador', $es_administrador, PDO::PARAM_BOOL);
    $sentencia->execute();

    // Redirigir o mostrar un mensaje de éxito
    header('Location: alumnos/administrazioa.php');
    exit();
  } catch (PDOException $error) {
    $error = $error->getMessage();
    echo $error;
  }
}
?>

</body>
</html>


