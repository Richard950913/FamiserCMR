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
<script>
    //Busqueda cliente x AJAX

getData(); // Llamada inicial para cargar los datos al cargar la página
document.getElementById("busqueda").addEventListener("keyup", getData);

function getData() {
    let input = document.getElementById("busqueda").value;
    let content = document.getElementById("content");
    let url = "loadcl.php";
    let formData = new FormData();
    formData.append('busqueda', input);

    fetch(url, {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.html) {
                content.innerHTML = data.html; // Actualiza el contenido de la tabla con el HTML recibido
            } else {
                console.log("No se recibió HTML en la respuesta JSON.");
            }
        })
        .catch(err => console.log(err));
}
</script>
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



</script>
<script>
    // Funcion de Ajax para verificar el cliente existente automaticamente
function verificarClienteExistente() {
    var numID = document.getElementById("numID").value.trim();

    if (numID === "") {
        document.getElementById("clienteExistenteMsg").innerText = "";
        document.getElementById("clienteExistenteIcon").style.display = "none";
        return;
    }

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
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
    // Especifica la ruta al archivo verificar_cliente.php
    xhttp.open("POST", "verificar_cliente.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("numID=" + numID);
}

document.getElementById("numID").addEventListener("input", verificarClienteExistente);


</script>
<!-- Script de jQuery para enviar los datos del formulario mediante AJAX -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#registro-form').submit(function (event) {
                event.preventDefault(); // Evitar el envío del formulario por defecto
                $.ajax({
                    type: 'POST',
                    url: 'registrar_cliente.php', // Ruta al archivo PHP que maneja el registro
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function (response) {
                        // Mostrar mensaje de éxito o error
                        var messageContainer = $('#mensaje-container');
                        if (response.success) {
                            messageContainer.text(response.message).css('color', 'green');
                        } else {
                            messageContainer.text(response.message).css('color', 'red');
                        }
                    },
                    error: function () {
                        $('#mensaje-container').text('Error al procesar la solicitud.').css('color', 'red');
                    }
                });
            });
        });
    </script>

    <!--Eliminar cliente-->
<script>
    function eliminarCliente(id, nombre) {
        var confirmacion = confirm("¿Está seguro de eliminar este registro? " + nombre);

        if (confirmacion) {
            // Enviar la solicitud AJAX para eliminar el cliente
            $.ajax({
                type: 'POST',
                url: 'eliminar_cliente.php',
                data: { id: id },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        // Eliminación exitosa
                        alert("El cliente ha sido eliminado correctamente.");
                        // Aquí puedes recargar la lista de clientes si lo deseas
                    } else {
                        // Error al eliminar el cliente
                        alert("Error al eliminar el cliente: " + response.message);
                    }
                },
                error: function () {
                    // Error de conexión
                    alert("Error al procesar la solicitud. Por favor, inténtelo nuevamente.");
                }
            });
        }
    }
</script>

</body>

</html>