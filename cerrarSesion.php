<?php
session_start();
$_SESSION = array();  // Limpiar todas las variables de sesión
session_destroy();  // Destruir la sesión
header('Location: login.php');  // Redireccionamiento login después de cerrar sesión
exit;
?>
