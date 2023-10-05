<?php

include 'funciones.php';
session_start(); // Iniciar la sesión al comienzo del archivo

csrf();

if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

$config = include 'config.php';

if (isset($_POST['usuario'], $_POST['contrasena'])) {
  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Consulta SQL para buscar al usuario
    $consultaSQL = "SELECT id, usuario, contraseña, administrador FROM usuarios WHERE usuario = :usuario";
    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->bindParam(':usuario', $usuario);
    $sentencia->execute();

    $usuarioEncontrado = $sentencia->fetch(PDO::FETCH_ASSOC);

    if ($usuarioEncontrado && password_verify($contrasena, $usuarioEncontrado['contraseña'])) {
      // Las credenciales son válidas, iniciar sesión
      $_SESSION['usuario_id'] = $usuarioEncontrado['id'];
      $_SESSION['nombre_usuario'] = $usuarioEncontrado['usuario'];

      $_SESSION['administrador'] = $usuarioEncontrado['administrador'];
  
      // Redirigir a la página de inicio
      if ($usuarioEncontrado['administrador']) {
        // Si es administrador, redirigir a la página de administrador
        header('Location: alumnos/administrazioa.php');
      } else {
        // Si no es administrador, redirigir a la página de usuario normal
        header('Location: index.php');
      }
      exit();
    } else {
      $error = "Credenciales incorrectas";
      echo $error;
    }
  } catch(PDOException $error) {
    $error = $error->getMessage();
    echo $error;
  }
}


























/*
include 'funciones.php';

csrf();

if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

$config = include 'config.php';

if (isset($_POST['usuario'], $_POST['contrasena'])) {
  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Consulta SQL para buscar al usuario
    $consultaSQL = "SELECT * FROM usuarios WHERE usuario = :usuario";
    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->bindParam(':usuario', $usuario);
    $sentencia->execute();

    $usuarioEncontrado = $sentencia->fetch(PDO::FETCH_ASSOC);
    echo " contraseña".$contrasena;

    function compararContrasenas($contrasenaUsuario, $contrasenaAlmacenada) {
      // Realiza la comparación de contraseñas en texto plano
      return $contrasenaUsuario === $contrasenaAlmacenada;
  }
    ///$usuarioEncontrado['contraseña']
    if (compararContrasenas($contrasena, $usuarioEncontrado['contraseña'])) {
      // Las credenciales son válidas, iniciar sesión
      session_start();
      $_SESSION['usuario_id'] = $usuarioEncontrado['id'];
      $_SESSION['nombre_usuario'] = $usuarioEncontrado['usuario']; // Almacena el nombre de usuario en la sesión

      // Redirigir a la página de inicio
      header('Location: administrazioa.php');
      exit(); // Salir para evitar cualquier salida adicional
    } else {
      $error = "Nombre de usuario o contraseña incorrectos";
      echo $error;
    }
  } catch(PDOException $error) {
    $error = $error->getMessage();
    echo $error;
  }
}
*/?>

