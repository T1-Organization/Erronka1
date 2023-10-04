<?php
// Iniciar la sesión (si aún no está iniciada)
session_start();

// Destruir la sesión
session_destroy();

// Redirigir al usuario a la página de inicio de sesión o a otra página
header("Location: administrazioa.php"); // Cambia "inicio_sesion.php" a la página que desees
exit;
?>