<?php
include("sesion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style2.css">
    <title>Dashboard</title>
</head>
<body>
    <div class="dashboard-container">
        <img class="logo" src="images/LOGO.png" alt="Logo">
        <div class="user-info">
            <p>Bienvenido, <?php echo $username; ?></p>
            <p>&nbsp;&nbsp;</p>
            <form action="" method="POST">
                <input type="hidden" name="logout" value="true">
                <button type="submit" class="logout-btn">Cerrar sesión</button>
            </form>
        </div>
    </div>
    <div class="dashboard-container">
        
    </div>
    <div class="menu-bar">
        <a href="dashboard.php">INICIO</a>
        <div class="dropdown">
            <button class="dropbtn">MENU</button>
            <div class="dropdown-content">
                <a href="regcliente\registro_cliente_form.php">Registrar cliente</a>
                <a href="#">Compra de lente</a>
                <a href="#">Compra de Credencial</a>
                <a href="#">Abonos</a>
                <a href="#">Garantias</a>
                <a href="#">Incidentes</a>
                <a href="#">Proceso de Lentes</a>
            </div>
        </div>
        <a href="#">SOPORTE</a>
    </div>
    <script src="script.js"></script>
</body>
</html>


