<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$roles_permitidos = [1, 2, 4]; // Agregamos el rol 4 para permitir el acceso, pero será de solo lectura

if (!isset($_SESSION['rol_ID']) || !in_array($_SESSION['rol_ID'], $roles_permitidos)) {
    // Si el rol no es 1, 2 o 4, mostrar un mensaje y redirigir después de 2 segundos
    echo '<script>
        window.onload = function() {
            alert("No tienes permitido el acceso. Por favor, contacta con administración.");
            window.location.href = "/ini/dashboard.php";
        }
    </script>';
    exit();
}

// Variable para solo lectura
$solo_lectura = $_SESSION['rol_ID'] == 4;
?>
