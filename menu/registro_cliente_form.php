<?php
include ("../conexion.php");
include ("../sesion.php");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style2.css">
    <title>Dashboard</title>
</head>
<body>
    <div class="dashboard-container">
        <img class="logo" src="../images/LOGO.png" alt="Logo">
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
    <script src="script.js"></script>

    <div class="container">
        <h2>Registro de Clientes</h2>
        <form method="post" action="registrar_cliente.php" onsubmit="return validarEmail()">
            <label for="tipoID">Tipo de ID:</label>
            <select class="form-select" name="tipoID" id="tipoID" required>
                <option value="C.C">C.C</option>
                <option value="C.E">C.E</option>
                <option value="T.I">T.I</option>
                <option value="Pasaporte">Pasaporte</option>
                <option value="Otro">Otro</option></select>
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
            <input type="email" id="email" name="email" >
            <label for="fec_nac">Fecha de nacimiento:</label>
            <input type="date" id="fec_nac" name="fec_nac">
            <label for="oficio">Oficio:</label>
            <input type="text" id="oficio" name="oficio">
            <label for="empresa">Empresa:</label>
            <input type="text" id="empresa" name="empresa">
            <input type="submit" value="Registrar">
        </form>
    </div>

    <div class="container">
        <h2>Búsqueda de Cliente</h2>
        <input type="text" id="busqueda" placeholder="Buscar cliente...">
        <button id="buscarBtn">Buscar</button>
    </div>

    <script>
        // Función para validar el correo electrónico
    function validarEmail() {
        var emailInput = document.getElementById("email").value.trim(); // Eliminar espacios en blanco al principio y al final
        // Si el campo está en blanco, permitir que se envíe el formulario
        if (emailInput === "") {
            return true;
        }
        // Si el campo no está en blanco, validar el formato del correo electrónico
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(emailInput)) {
            alert("El email proporcionado no sigue un formato regular.");
            return false; // Evitar que se envíe el formulario
        }
        return true; // Permitir el envío del formulario
    }


    // Script de búsqueda de cliente
    function buscarCliente() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("busqueda");
        filter = input.value.toUpperCase();
        table = document.getElementById("clientes");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    // Asociar la función de búsqueda al evento de pulsación de tecla
    document.getElementById("busqueda").addEventListener("keyup", buscarCliente);
    </script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    function verificarClienteExistente() {
        var numID = document.getElementById("numID").value.trim();

        if (numID === "") {
            document.getElementById("clienteExistenteMsg").innerText = "";
            document.getElementById("clienteExistenteIcon").style.display = "none";
            return;
        }

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                var response = this.responseText;
                if (response === "existe") {
                    document.getElementById("clienteExistenteMsg").innerText = "Cliente ya existente";
                    document.getElementById("clienteExistenteMsg").style.color = "red";
                    document.getElementById("clienteExistenteIcon").style.display = "none";
                } else {
                    document.getElementById("clienteExistenteMsg").innerText = "";
                    document.getElementById("clienteExistenteIcon").style.display = "inline";
                }
            }
        };
        xhttp.open("POST", "verificar_cliente.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("numID=" + numID);
    }

    document.getElementById("numID").addEventListener("input", verificarClienteExistente);
</script>



</body>
</html>
