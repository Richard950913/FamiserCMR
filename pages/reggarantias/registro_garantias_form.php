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
    <link rel="stylesheet" href="../../styles/styleplan.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" />
    <title>Registro de garantias</title>
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
        <h2>REGISTRO DE GARANTIAS</h2>
        <form method="post" id="registro-form">

            <label for="cupo">Cupo:</label>
            <input type="number" class="main" id="cupo" name="cupo" min="1" maxlength="11">
            <span id="cupo-status"></span>
            <div style="display: block;">
            <label for="fec_gar">Fecha de garantias:</label>
            <input class="form-select main" type="date" id="fec_gar" name="fec_gar" required>

            <div style="display: block;">
                <label for="estado_gar">Estado:</label>
                <select class="form-select main" name="estado_gar" id="estado_gar" required>
                    <option value=""></option>
                    <option value="PENDIENTE">PENDIENTE</option>
                    <option value="SOLUCIONADA">SOLUCIONADA</option>
                </select>

                <div style="display: block;">
                    <label for="tipo_garantia">Producto:</label>
                    <select class="form-select main" name="tipo_garantia" id="tipo_garantia" required>
                        <option value=""></option>
                        <option value="FORMULA">FORMULA</option>
                        <option value="MARCO">MARCO</option>
                        <option value="TIPO DE LENTE">TIPO DE LENTE</option>
                        <option value="OTROS">OTROS</option>
                    </select>
                    <div style="display: block;">
                    <label for="nuev_form">Formula nueva (si aplica):</label>
                    <input type="text" id="nuev_form" name="nuev_form">
                    <div style="display: block;"></div>
                    <label for="nuev_opt">Optometra nuevo (si aplica):</label>
                    <input type="text" id="nuev_opt" name="nuev_opt">
                    <div style="display: block;"></div>
                    <label for="comentarios">Comentarios:</label>
                    <textarea type="textarea" id="comentarios" name="comentarios"></textarea>

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
