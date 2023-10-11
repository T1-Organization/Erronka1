<?php
 // Incluir la clase Usuario y la lógica necesaria
 require_once 'config.php'; // Ajusta la ruta a tu archivo de configuración
 require_once 'controller/UsuarioController.php'; // Ajusta la ruta a tu controlador de usuarios
 require_once 'model/Usuario.php';
 
// Verificar si se recibió una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el ID del usuario a eliminar desde el formulario
    if (isset($_POST['id_usuario'])) {
        $idUsuario = $_POST['id_usuario'];

        // Intentar eliminar el usuario
        if (Usuario::borrarDeBaseDeDatos($idUsuario)) {
            // Usuario eliminado con éxito
            // Redirigir a una página de éxito o mostrar un mensaje de éxito
            header('Location: administrazioa.php');
            exit();
        } else {
            // Error al eliminar el usuario
            // Redirigir a una página de error o mostrar un mensaje de error
            //header('Location: error.php');
            exit();
        }
    }
}

// Si no se recibió una solicitud POST válida, redirigir a una página de error
header('Location: error.php');
exit();
?>
