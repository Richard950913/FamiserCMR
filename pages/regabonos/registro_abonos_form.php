<?php
include ("../../conn/conexion.php");
include ("../../conn/sesion.php");
include ("../../conn/vr_mixto.php");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/styleplan.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" />
    <title>Registro abonos</title>
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
        <h2>REGISTRO DE ABONOS</h2>
        <form method="post" id="registro-form">

            <label for="fec_abono">Fecha de abono:</label>
            <input class="form-select main" type="date" id="fec_abono" name="fec_abono" required>
            <div style="display: block;">
                <label for="producto">Producto:</label>
                <select class="form-select main" name="producto" id="producto" required>
                    <option value=""></option>
                    <option value="LENTES">LENTES</option>
                    <option value="CREDENCIAL">CREDENCIAL</option>
                </select>

                <div id="cupolentes-container" style="display:none;">
                    <label for="cupolentes">CUPO:</label>
                    <input type="number" class="main" id="cupolentes" name="cupolentes" min="1" maxlength="11">
                    <span id="cupolentes-status"></span>
                </div>

                <div id="cupoplan-container" style="display:none;">
                    <label for="cupoplan">CUPO:</label>
                    <input type="number" class="main" id="cupoplan" name="cupoplan" min="1" maxlength="11">
                    <span id="cupoplan-status"></span>
                </div>
                <div style="display: block;">
                    <label for="tipo_abono">Tipo de abono:</label>
                    <select class="form-select main" name="tipo_abono" id="tipo_abono" required>
                        <option value=""></option>
                        <option value="EFECTIVO">EFECTIVO</option>
                        <option value="DATAFONO">DATAFONO</option>
                        <option value="CONSIGNACION">CONSIGNACION</option>
                    </select>
                    <div style="display: block;">
                        <label for="num_recibo">RECIBO Nº:</label>
                        <input type="text" id="num_recibo" name="num_recibo" required>

                        <label for="valor">Valor total:</label>
                        <input type="number" class="main" id="valor" name="valor" min="1" required>
                        <div style="display: block;">
                            <label for="cod_cobrador">CODIGO COBRADOR:</label>
                            <input type="number" class="main" id="cod_cobrador" name="cod_cobrador" min="1"
                                maxlength="3" required>

                            <!-- Contenedor para mostrar mensajes -->
                            <div id="mensaje-container"></div>
                            <div style="display: block;">
                                <!-- Botones: Guardar y Limpiar -->
                                <input type="submit" value="Registrar" class="btn-registrar">
                                <input type="button" value="Limpiar" onclick="limpiarCampos()" class="btn-limpiar">
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/main.js"></script>
    
</body>

</html>