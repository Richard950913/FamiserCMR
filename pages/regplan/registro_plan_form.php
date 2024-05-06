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

    <title>Dashboard</title>
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
        <h2>REGISTRO DEL PLAN</h2>
        <form method="post" id="registro-form">
            <label for="cupoplan">CUPO:</label>
            <input type="number" class="main" id="cupoplan" name="cupoplan"
                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                maxlength="5" required>

            <span id="cupo-validacion"></span>

            <div style="display: block;">
                <label for="estado">Estado:</label>
                <select class="form-select main" name="estado" id="estado" required>
                    <option value="PENDIENTE">Pendiente</option>
                    <option value="CANCELADO">Cancelado</option>
                    <option value="DEVOLUCION">Devolución</option>
                </select>
                <label for="fec_vinculacion">Fecha de vinculación:</label>
                <input class="form-select main" class="main" type="date" id="fec_vinculacion" name="fec_vinculacion"
                    required>
                <label for="tipo_plan">Tipo de plan:</label>
                <select class="form-select main" name="tipo_plan" id="tipo_plan" required
                    onchange="mostrarCamposAdicionales()">
                    <option value="1">Plan 1</option>
                    <option value="2">Plan 2</option>
                    <option value="3">Plan 3</option>
                </select>
                <div style="display: block;">
                    <label for="id_titular">ID del titular:</label>
                    <input type="number" class="main" id="id_titular" name="id_titular" required
                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                maxlength="15">

            <span id="icono-validacion"></span> <!-- Aquí se mostrará el icono de verificación o X -->
                    <div style="display: block;">
                        <label for="valor_total">Valor total:</label>
                        <input type="number" class="main" id="valor_total" name="valor_total">

                        <label for="forma_pago">Forma de pago:</label>
                        <select class="form-select main" name="forma_pago" id="forma_pago" required>
                            <option value="CONTADO">Contado</option>
                            <option value="CREDITO">Crédito</option>
                        </select>
                        <div style="margin-left: 100%;"></div>
                        <!-- Persona 1 -->
                        <label for="persona1">Persona 1:</label>
                        <input type="text" id="persona1" name="persona1">
                        <label for="fec_nac1">Fecha de nacimiento 1:</label>
                        <input class="form-select" type="date" id="fec_nac1" name="fec_nac1">
                        <label for="parentesco1">Parentesco 1:</label>
                        <input type="text" id="parentesco1" name="parentesco1">
                        <div style="margin-left: 100%;"></div>
                        <!-- Persona 2 -->
                        <label for="persona2">Persona 2:</label>
                        <input type="text" id="persona2" name="persona2">
                        <label for="fec_nac2">Fecha de nacimiento 2:</label>
                        <input class="form-select" type="date" id="fec_nac2" name="fec_nac2">
                        <label for="parentesco2">Parentesco 2:</label>
                        <input type="text" id="parentesco2" name="parentesco2">
                        <div style="margin-left: 100%;"></div>

                        <!-- Persona 3 -->
                        <label for="persona3">Persona 3:</label>
                        <input type="text" id="persona3" name="persona3">
                        <label for="fec_nac3">Fecha de nacimiento 3:</label>
                        <input class="form-select" type="date" id="fec_nac3" name="fec_nac3">
                        <label for="parentesco3">Parentesco 3:</label>
                        <input type="text" id="parentesco3" name="parentesco3">
                        <div style="margin-left: 100%;"></div>

                        <div class="extra-personas">
                            <!-- Persona 4 -->
                            <label for="persona4">Persona 4:</label>
                            <input type="text" id="persona4" name="persona4">
                            <label for="fec_nac4">Fecha de nacimiento 4:</label>
                            <input class="form-select" type="date" id="fec_nac4" name="fec_nac4">
                            <label for="parentesco4">Parentesco 4:</label>
                            <input type="text" id="parentesco4" name="parentesco4">
                            <div style="margin-left: 100%;"></div>

                            <!-- Persona 5 -->
                            <label for="persona5">Persona 5:</label>
                            <input type="text" id="persona5" name="persona5">
                            <label for="fec_nac5">Fecha de nacimiento 5:</label>
                            <input class="form-select" type="date" id="fec_nac5" name="fec_nac5">
                            <label for="parentesco5">Parentesco 5:</label>
                            <input type="text" id="parentesco5" name="parentesco5">
                            <div style="margin-left: 100%;"></div>

                            <!-- Persona 6 -->
                            <label for="persona6">Persona 6:</label>
                            <input type="text" id="persona6" name="persona6">
                            <label for="fec_nac6">Fecha de nacimiento 6:</label>
                            <input class="form-select" type="date" id="fec_nac6" name="fec_nac6">
                            <label for="parentesco6">Parentesco 6:</label>
                            <input type="text" id="parentesco6" name="parentesco6">
                            <div style="margin-left: 100%;"></div>

                            <!-- Persona 7 -->
                            <label for="persona7">Persona 7:</label>
                            <input type="text" id="persona7" name="persona7">
                            <label for="fec_nac7">Fecha de nacimiento 7:</label>
                            <input class="form-select" type="date" id="fec_nac7" name="fec_nac7">
                            <label for="parentesco7">Parentesco 7:</label>
                            <input type="text" id="parentesco7" name="parentesco7">
                            <div style="margin-left: 100%;"></div>
                        </div>

                        <label for="comentarios">Comentarios:</label>
                        <textarea type="textarea" id="comentarios" name="comentarios"></textarea>
                        <div style="display: block;">
                            <label for="empresa" id="empresaLabel" style="display: none;">Empresa:</label>
                            <input type="text" id="empresa" name="empresa" style="display: none;">


                            <!-- Contenedor para mostrar mensajes -->
                            <div id="mensaje-container"></div>
                            <!-- Botones: Guardar y Limpiar -->
                            <div style="margin-left: 100%;"></div>
                            <input type="submit" value="Registrar" class="btn-registrar">
                            <input type="submit" value="Limpiar" onclick="limpiarCampos()" class="btn-limpiar">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="container">
        <h2>Búsqueda de Cliente</h2>
        <input type="text" id="busqueda" placeholder="Buscar cliente...">

        <p></p>

        <table>
            <thead>
                <th>Cupo</th>
                <th>Estado</th>
                <th>Fecha Vinculacion</th>
                <th>Plan</th>
                <th>ID Titular</th>
                <th>Valor</th>
                <th>Medio Pago</th>
                
                <th></th>
                <th></th>
            </thead>

            <tbody id="content">

            </tbody>
        </table>
    </div>
   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/DOM.js"></script>
</body>

</html>