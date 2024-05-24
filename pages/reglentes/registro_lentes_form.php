<?php
include ("../../conn/conexion.php");
include ("../../conn/sesion.php");
include ("../../conn/vr_opt.php");

// Verificar si el usuario tiene el rol 4 y restringir el acceso
if ($_SESSION['rol_ID'] == 4) {
    // Redirigir a una página de acceso denegado o mostrar un mensaje de error
    echo '<script>
        window.onload = function() {
            alert("No tienes permitido el acceso. Por favor, contacta con administración.");
            window.location.href = "/ini/dashboard.php";
        }
    </script>';
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/stylelentes.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" />

    <title>registro lentes</title>
    <style>
        .mensaje-exito {
            color: green;
        }

        .mensaje-error {
            color: red;
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
        <h2>COMPRA DE LENTES</h2>
        <form method="post" id="registro-form">
            <label for="cupolente"># de cupo:</label>
            <input type="number" id="cupolente" name="cupolente" required min="1" pattern="^[0-9]+"
                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                maxlength="11">

            <span id="cupo-validacion"></span>
            <div style="margin-left: 100%;"></div>

            <label for="estado">Estado:</label>
            <select class="form-select main" name="estado" id="estado" required>
                <option value="PENDIENTE">Pendiente</option>
                <option value="CANCELADO">Cancelado</option>
                <option value="DEVOLUCION">Devolución</option>
            </select>
            <label for="idcliente">Id cliente:</label>
            <input type="number" id="idcliente" name="idcliente" required min="1" pattern="^[0-9]+"
                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                maxlength="15">

            <span id="icono-validacion"></span> <!-- Aquí se mostrará el icono de verificación o X -->
            <div style="display: block;">
                <label for="fec_compra">Fecha de compra:</label>
                <input class="form-select main" type="date" id="fec_compra" name="fec_compra" required>
                <div style="display: block;"></div>
                <label for="tipo_lente">Tipo de lente:</label>
                <select class="form-select main" name="tipo_lente" id="tipo_lente">
                    <option value=""></option>
                    <option value="MONOFOCAL + ">MONOFOCAL</option>
                    <option value="BIFOCAL + ">BIFOCAL</option>
                    <option value="POLICARBONATO + ">POLICARBONATO</option>
                    <option value="N/A">N/A</option>
                </select>
                <label for="filtro">Filtro:</label>
                <select class="form-select" name="filtro" id="filtro">
                    <option value=""></option>
                    <option value="AR ">AR</option>
                    <option value="BLUE ">BLUE</option>
                    <option value="FOTO + BLUE ">FOTO + BLUE</option>
                    <option value="FOTO ">FOTO</option>
                    <option value="TRANSITION ">TRANSITION</option>
                    <option value="N/A">N/A</option>
                </select>
                <label for="graduacion">Graduación:</label>
                <select class="form-select" name="graduacion" id="graduacion">
                    <option value=""></option>
                    <option value="SENCILLAS">SENCILLAS</option>
                    <option value="TALLADAS">TALLADAS</option>
                    <option value="N/A">N/A</option>
                </select>
                <label for="comp_adic">Compras adicionales:</label>
                <select class="form-select" name="comp_adic" id="comp_adic">
                    <option value=""> </option>
                    <option value="GOTAS">GOTAS</option>
                    <option value="MONTURA">MONTURA</option>
                    <option value="LENTES DE CONTACTO">LENTES DE CONTACTO</option>
                    <option value="OTROS">OTROS</option>
                    <option value="N/A">N/A</option>
                </select>
                <div style="display: block;"></div>
                <label for="valor_total">Valor total:</label>
                <input type="number" id="valor_total" name="valor_total" min="1" pattern="^[0-9]+">
                <label for="sist_pago">Sistema de pago:</label>
                <select class="form-select" name="sist_pago" id="sist_pago" required>
                    <option value="CONTADO">CONTADO</option>
                    <option value="CREDITO">CREDITO</option>
                    <option value="SISTECREDITO">SISTECREDITO</option>
                </select>
                <div style="margin-left: 100%;"></div>
                <label for="formula">FÓRMULA:</label>
                <input type="text" id="formula" name="formula" style="width: 70%;" required>
                <div style="display: block;"></div>
                <label for="optometra"> Optómetra</label>
                <select class="form-select main" name="optometra" id="optometra"></select>
                <div style="margin-left: 100%;"></div>
                <label for="comentarios">Comentarios:</label>
                <textarea id="comentarios" name="comentarios"></textarea>

                <div style="margin-left: 100%;"></div>

                <!-- Botón de guardar -->
                <input type="submit" value="Registrar" class="btn-registrar">
                <input type="submit" value="Limpiar" onclick="limpiarCampos()" class="btn-limpiar">
                <div id="mensaje-container"></div>
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/main.js"></script>

</body>

</html>