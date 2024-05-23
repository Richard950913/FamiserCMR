<?php
session_start(); // Asegúrate de iniciar la sesión si no está ya iniciada

$roles_permitidos = [1, 2, 3];
$solo_lectura = false;

if (!isset($_SESSION['rol_ID'])) {
    // Si no hay rol_ID en la sesión, redirigir al inicio de sesión
    echo '<script>
        window.onload = function() {
            alert("No tienes permitido el acceso. Por favor, contacta con administración.");
            window.location.href = "/ini/dashboard.php";
        }
    </script>';
    exit();
} else if (!in_array($_SESSION['rol_ID'], $roles_permitidos)) {
    if ($_SESSION['rol_ID'] == 4) {
        $solo_lectura = true;
    } else {
        // Si el rol no es permitido, redirigir
        echo '<script>
            window.onload = function() {
                alert("No tienes permitido el acceso. Por favor, contacta con administración.");
                window.location.href = "/ini/dashboard.php";
            }
        </script>';
        exit();
    }
}
?>

