<?php
include ("../../conn/conexion.php");
include ("../../conn/sesion.php");
include ("../../conn/vr_opt.php");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/styleprocesos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" />
    <title>Registro de incidentes</title>
</head>

<body>
    <div class="dashboard-container">
        <img class="logo" src="../../images/LOGO.png" alt="Logo">
        <div class="user-info">
            <p>Bienvenido, <?php echo $username; ?></p>
            <p>&nbsp;&nbsp;</p>
            <form action="" method="POST">
                <input type="hidden" name="logout" value="true">
                <button type="submit" class="logout-btn">Cerrar sesión</button>
            </form>
        </div>
    </div>
    <div class="dashboard-container"></div>
    <div class="menu-bar">
        <a href="/ini/dashboard.php">INICIO</a>
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
        <h2>PROCESOS DE LENTES LABORATORIO Y ENTREGAS</h2>
        <form method="post" id="registro-form">
            <label for="cupo_id">CUPO:</label>    
            <input type="number" class="main" id="cupo_id" name="cupo_id" min="1" maxlength="11">
            <span id="cupo-status"></span>
            <div style="display: block;">
                <label for="fec_mand">Fecha enviado a lab:</label>
                <input class="form-select main" type="date" id="fec_mand" name="fec_mand" required>
            </div>
            <div style="display: block;"></div>
            <label for="num_talonario">Talonario Nº:</label>
            <input type="text" id="num_talonario" name="num_talonario" required>
            <div style="display: block;"></div>
            <label for="proceso">Proceso:</label>
            <select class="form-select main" name="proceso" id="proceso" required>
                <option value=""></option>
                <option value="ENVIADO">ENVIADO</option>
                <option value="RECIBIDO">RECIBIDO</option>
                <option value="DESPACHADO">DESPACHADO</option>
                <option value="OFICINA">OFICINA</option>
            </select>
            <div style="display: block;"></div>
            <label for="despach_por">Despachado por (si aplica):</label>
            <input type="text" id="despach_por" name="despach_por">
            <div style="display: block;"></div>
            <label for="si_garantia">Garantia:</label>
            <select class="form-select main" name="si_garantia" id="si_garantia" >
                <option value=""></option>
                <option value="NO">NO</option>
                <option value="SI">SI</option>
            </select>
            <!-- Contenedor para mostrar mensajes -->
            <div id="mensaje-container"></div>
            <div style="display: block;">
                <!-- Botones: Guardar y Limpiar -->
                <input type="submit" value="Registrar" class="btn-registrar">
                <input type="button" value="Limpiar" onclick="limpiarCampos()" class="btn-limpiar">
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/main.js"></script>

</body>

</html>
