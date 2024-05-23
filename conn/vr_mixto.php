<?php


$roles_permitidos = [1, 2, 3];

if (!isset($_SESSION['rol_ID']) || !in_array($_SESSION['rol_ID'], $roles_permitidos)) {
    // Si el rol no es 1 o 2, mostrar un mensaje y redirigir después de 2 segundos
    echo '<script>
        window.onload = function() {
            alert("No tienes permitido el acceso. Por favor, contacta con administración.");
            
                window.location.href = "/ini/dashboard.php";
            
        }
    </script>';
    exit();
}
?>
