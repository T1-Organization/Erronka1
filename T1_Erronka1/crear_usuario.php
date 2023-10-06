<?php
// Asegúrate de incluir tus archivos de configuración y clases necesarios
require_once 'config.php'; // Ajusta la ruta a tu archivo de configuración
require_once 'controller/UsuarioController.php'; // Ajusta la ruta a tu controlador de usuarios
require_once 'model/Usuario.php'; // Ajusta la ruta a tu modelo de usuarios

// Verifica si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Realiza la validación CSRF aquí (debes tener esta lógica implementada)

    // Recopila los datos del formulario
    $nombreUsuario = $_POST['usuario'];
    $contrasena = $_POST['contraseña'];
    $administrador = isset($_POST['administrador']) ? 1 : 0; // 1 si está marcado, 0 si no
    $alumnoId = $_POST['alumnoId'];

    // Crea una instancia del controlador de usuarios
    $usuariosController = new UsuarioController();

    // Crea un nuevo objeto Usuario
    $nuevoUsuario = new Usuario( $nombreUsuario, $contrasena, $administrador, $alumnoId);

    // Intenta guardar el nuevo usuario en la base de datos
    if ($usuariosController->crearUsuario($nuevoUsuario)) {
        // Éxito: el usuario se creó correctamente
        // Puedes redirigir o mostrar un mensaje de éxito
        header('Location: crear_usuario.php');
        exit();
    } else {
        // Error al crear el usuario
        // Puedes redirigir o mostrar un mensaje de error
        header('Location: crear_usuario.php');
        exit();
    }
} else {
    // Redirige si se intenta acceder directamente a este script sin enviar el formulario
    header('Location: crear_usuario.php');
    exit();
}
?>

