<?php

session_start();

if (!isset($_SESSION['username'])) {
    // Si el usuario no está autenticado, redirigir a la página de login
    header("Location: /ini/index.html");
    exit();
}

$username = $_SESSION['username'];

// Procesar el cierre de sesión
if(isset($_POST['logout'])) {
    // Destruir la sesión
    session_destroy();
    // Redirigir al usuario al login
    header("Location: /ini/index.html");
    exit();
}
?>