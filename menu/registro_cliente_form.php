<?php
include ("../conexion.php");
include ("../sesion.php");
include ("../validar_rol.php");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style2.css">
    <title>Dashboard</title>
    <style>
        table,
        th,
        td {
            border: 1px solid;
        }

        table {
            width: 80%;
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <img class="logo" src="../images/LOGO.png" alt="Logo">
        <div class="user-info">
            <p>Bienvenido,
                <?php echo $username; ?>
            </p>
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
        <a href="../dashboard.php">INICIO</a>
        <div class="dropdown">
            <button class="dropbtn">MENU</button>
            <div class="dropdown-content">
                <a href="#">Registrar cliente</a>
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


    <div class="container">
        <h2>Registro de Clientes</h2>
        <form method="post" action="" onsubmit="return validarEmail()" id=registro-form>
            <label for="tipoID">Tipo de ID:</label>
            <select class="form-select" name="tipoID" id="tipoID" required>
                <option value="C.C">C.C</option>
                <option value="C.E">C.E</option>
                <option value="T.I">T.I</option>
                <option value="Pasaporte">Pasaporte</option>
                <option value="Otro">Otro</option>
            </select>
            <label for="numID">Número de ID:</label>
            <input type="number" id="numID" name="numID" required>
            <span id="clienteExistenteMsg" style="color: red;"></span>
            <img id="clienteExistenteIcon" src="../images/check.svg" alt="Cliente disponible" style="display: none;">
            <label for="nombresCL">Nombres:</label>
            <input type="text" id="nombresCL" name="nombresCL" required>
            <label for="sexo">Sexo:</label>
            <select name="sexo" id="sexo">
                <option value=""></option>
                <option value="F">F</option>
                <option value="M">M</option>
            </select>
            <label for="lugar">Lugar:</label>
            <input type="text" id="lugar" name="lugar" required>
            <label for="telefono1">Teléfono 1:</label>
            <input type="tel" id="telefono1" name="telefono1">
            <label for="telefono2">Teléfono 2:</label>
            <input type="tel" id="telefono2" name="telefono2">
            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email">
            <label for="fec_nac">Fecha de nacimiento:</label>
            <input type="date" id="fec_nac" name="fec_nac">
            <label for="oficio">Oficio:</label>
            <input type="text" id="oficio" name="oficio">
            <label for="empresa">Empresa:</label>
            <input type="text" id="empresa" name="empresa">
            <input type="submit" value="Registrar">
            <div id="mensaje-container" class="anuncio"></div>
        </form>
    </div>

    <div class="container">
        <h2>Búsqueda de Cliente</h2>
        <input type="text" id="busqueda" placeholder="Buscar cliente...">

        <p></p>
       
        <table>
            <thead>
            <th>ID Cliente</th>
                <th>Tipo ID</th>
                <th>Num. ID </th>
                <th>Nombres</th>
                <th>Sexo</th>
                <th>Lugar ID</th>
                <th>Telefono1</th>
                <th>Telefono2</th>
                <th>Direccion</th>
                <th>Correo</th>
                <th>Fec. Nac</th>
                <th>Oficio</th>
                <th>Empresa</th>
                <th></th>
                <th></th>
            </thead>

            <tbody id="content">

            </tbody>
        </table>
    </div>
<!-- Incluir el archivo de scripts -->
<script src="scriptrc.js"></script>

</body>

</html>