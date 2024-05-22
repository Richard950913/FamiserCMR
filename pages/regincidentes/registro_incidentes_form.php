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
        <h2>INCIDENTES</h2>
        <form method="post" id="registro-form" action="registro_incidentes.php">

            <label for="fec_incid">Fecha de incidente:</label>
            <input class="form-select main" type="date" id="fec_incid" name="fec_incid" required>
            <div style="display: block;"></div>

            <label for="estado">Estado:</label>
            <select class="form-select main" name="estado" id="estado" required>
                <option value=""></option>
                <option value="PENDIENTE">PENDIENTE</option>
                <option value="RESUELTO">RESUELTO</option>
            </select>
            <div style="display: block;"></div>
            <label for="qn_atend">Atendido por:</label>
            <input type="text" id="qn_atend" name="qn_atend" required>
            <div style="display: block;"></div>
            <label for="id_persona">Número de ID:</label>
            <input type="number" id="id_persona" name="id_persona" required min="1" pattern="^[0-9]+"
                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                maxlength="11" >
                <span id="cliente-status"></span>
            <div style="display: block;"></div>
            <label for="notas">Notas:</label> <div style="display: block;"></div>
            <textarea type="textarea" id="notas" name="notas" required></textarea>
            <div style="display: block;"></div>
            <label for="qn_resolv">Resuelto por:</label>
            <input type="text" id="qn_resolv" name="qn_resolv">
            <div style="display: block;"></div>
            
            <label for="solucion">Solucion:</label> <div style="display: block;"></div>
            <textarea type="textarea" id="solucion" name="solucion"></textarea>
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