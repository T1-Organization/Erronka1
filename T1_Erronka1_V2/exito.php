<?php
include 'funciones.php';

csrf();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
    die();
  }

  $usuario = $_POST['usuario'];
  $contrasena = $_POST['contrasena'];

  $config = include 'config.php';
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  $consultaSQL = "SELECT id, contraseña FROM usuarios WHERE usuario = :usuario";
  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->bindParam(':usuario', $usuario, PDO::PARAM_STR);
  $sentencia->execute();
  $resultado = $sentencia->fetch();

  if ($resultado && password_verify($contrasena, $resultado['contraseña'])) {
    // La contraseña es válida, iniciar sesión y redirigir al usuario
    session_start();
    $_SESSION['usuario_id'] = $resultado['id'];
    $_SESSION['usuario'] = $usuario; // Puedes almacenar otros datos de usuario aquí
    header('Location: alumnos/administrazioa.php'); // Redirigir a la página de inicio
    exit();
  } else {
    // La contraseña es incorrecta, mostrar un mensaje de error
    $error = "Nombre de usuario o contraseña incorrectos";
    echo $error;
  }
}
?>
