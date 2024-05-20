<?php
include ("../../conn/conexion.php");
include ("../../conn/sesion.php");
include ("../../conn/validar_rol.php");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/stylecliente.css">
    <title>registro clientes</title>
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
        <img class="logo" src="../../images/LOGO.png" alt="Logo">
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
        <a href="../../dashboard.php">INICIO</a>
        <div class="dropdown">
            <button class="dropbtn">MENU</button>
            <div class="dropdown-content">
                <a href="../../pages/regcliente/registro_cliente_form.php">Registrar cliente</a>
                <a href="../../pages/reglentes/registro_lentes_form.php">Compra de lente</a>
                <a href="../../pages/regplan/registro_plan_form.php">Compra de Credencial</a>
                <a href="../../pages/regabonos/registro_abonos_form.php">Abonos</a>
                <a href="../../pages/reggarantias/registro_garantias_form.php">Garantias</a>
                <a href="../../pages/regincidentes/registro_incidentes_form.php">Incidentes</a>
                <a href="../../pages/regprocesos/registro_procesos_form.php">Proceso de Lentes</a>
            </div>
        </div>
        <a href="#">SOPORTE</a>
    </div>


    <div class="container">
        <h2>Registro de Clientes</h2>
        <form method="post" onsubmit="return validarEmail()" id=registro-form>
            <label for="tipoID">Tipo de ID:</label>
            <select class="form-select" name="tipoID" id="tipoID" required>
                <option value="C.C">C.C</option>
                <option value="C.E">C.E</option>
                <option value="T.I">T.I</option>
                <option value="Pasaporte">Pasaporte</option>
                <option value="Otro">Otro</option>
            </select>
            <label for="numID">Número de ID:</label>
            <input type="number" id="numID" name="numID" required required min="1" pattern="^[0-9]+"
                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                maxlength="15">
            <span id="clienteExistenteMsg" style="color: red;"></span>
            <img id="clienteExistenteIcon" src="../../images/check.svg" alt="Cliente disponible" style="display: none;">
            <label for="nombresCL">Nombres:</label>
            <input type="text" id="nombresCL" name="nombresCL" required>
            <label for="sexo">Sexo:</label>
            <select class="form-select" name="sexo" id="sexo">
                <option value=""></option>
                <option value="F">F</option>
                <option value="M">M</option>
            </select>
            <label for="lugar">Lugar:</label>
            <input type="text" id="lugar" name="lugar" required>
            <label for="telefono1">Teléfono 1:</label>
            <input type="tel" id="telefono1" name="telefono1" min="1" pattern="^[0-9]+">
            <label for="telefono2">Teléfono 2:</label>
            <input type="tel" id="telefono2" name="telefono2" min="1" pattern="^[0-9]+">
            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email">
            <label for="fec_nac">Fecha de nacimiento:</label>
            <input type="date" class="form-select" id="fec_nac" name="fec_nac">
            <label for="oficio">Oficio:</label>
            <input type="text" id="oficio" name="oficio">
            <label for="empresa">Empresa:</label>
            <input type="text" id="empresa" name="empresa">
            <!-- Contenedor del campo de acudiente -->
            <div id="acudienteContainer" style="display: none;">
                <label for="acudiente">Acudiente:</label>
                <input type="text" id="acudiente" name="acudiente" style="width:60%">
            </div>
            
            <input type="submit" value="Registrar">
            <div style="margin-left: 65%;"></div>
            <input type="submit" value="limpiar" onclick="limpiarCampos()" style="background-color: #750303;">
            <div style="display: block;"></div>
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
                <th>Acudiente</th>
                <th></th>
                <th></th>
            </thead>

            <tbody id="content">

            </tbody>
        </table>
    </div>


    <div class="container">
        <label for="cantidadRegistros">Mostrar:</label>
        <select id="cantidadRegistros">
            <option value="10" selected>10</option>
            <option value="20">20</option>
            <option value="50">50</option>
        </select>
        registros

        <div id="paginationButtons">
            <button id="prevButton" disabled>Anterior</button>
            <button id="nextButton" disabled>Siguiente</button>
        </div>
        <!-- Contenedor para el total de registros -->
        <div class="total-registros-container">
            <span id="totalRegistrosSpan"></span>
        </div>

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/reg.js"></script>



</body>

</html>