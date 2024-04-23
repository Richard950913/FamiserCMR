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
    <link rel="stylesheet" href="../styles/style3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" />

    <title>Dashboard</title>

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
                <a href="../regcliente/registro_cliente_form.php">Registrar cliente</a>
                <a href="../reglentes/registro_lentes_form.php">Compra de lente</a>
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
        <h2>COMPRA DE LENTES</h2>
        <form method="post" id=registro-form>
            <label for="cupolente"># de cupo:</label>
            <input type="number" id="cupolente" name="cupolente" required oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="5">

            <span id="cupo-validacion"></span>
            <div style="margin-left: 100%;"></div>

            <label for="estado">Estado:</label>
            <select class="form-select" name="estado" id="estado" required>
                <option value="PENDIENTE">Pendiente</option>
                <option value="CANCELADO">Cancelado</option>
                <option value="DEVOLUCION">Devolución</option>
            </select>
            <label for="idcliente">Id cliente:</label>
            <input type="number" id="idcliente" name="idcliente" required oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="15">

            <span id="icono-validacion"></span> <!-- Aquí se mostrará el icono de verificación o X -->

            <label for="fec_compra">Fecha de compra:</label>
            <input class="form-select" type="date" id="fec_compra" name="fec_compra">
            <label for="tipo_lente">Tipo de lente:</label>
            <select class="form-select" name="tipo_lente" id="tipo_lente" required>
                <option value=""></option>
                <option value="M + ">M</option>
                <option value="B + ">B</option>
                <option value="P + ">P</option>
            </select>
            <label for="filtro">Filtro:</label>
            <select class="form-select" name="filtro" id="filtro" required>
                <option value=""></option>
                <option value="AR ">AR</option>
                <option value="BLUE ">BLUE</option>
                <option value="FOTO + BLUE ">FOTO + BLUE</option>
                <option value="FOTO ">FOTO</option>
                <option value="TRANSITION ">TRANSITION</option>
            </select>
            <label for="graduacion">Graduacióm:</label>
            <select class="form-select" name="graduacion" id="graduacion" required>
                <option value=""></option>
                <option value="1">1</option>
                <option value="2">2</option>
            </select>
            <label for="comp_adic">Compras adicionales:</label>
            <select class="form-select" name="comp_adic" id="comp_adic" required>
                <option value=""></option>
                <option value="GOTAS">GOTAS</option>
                <option value="MONTURA">MONTURA</option>
                <option value="LENTES DE CONTACTO">LENTES DE CONTACTO</option>
                <option value="OTROS">OTROS</option>
            </select>
            <label for="valor_total">Valor total:</label>
            <input type="number" id="valor_total" name="valor_total">
            <label for="sist_pago">Sistema de pago:</label>
            <select class="form-select" name="sist_pago" id="sist_pago" required>
                <option value="SISTECREDITO">Sistecredito</option>
                <option value="CONTADO">Contado</option>
                <option value="CREDITO">Crédito</option>
            </select>
            <div style="margin-left: 100%;"></div>
            <label for="formula">FÓRMULA:</label>
            <input type="text" id="formula" name="formula" style="width: 70%;">
            <label for="optometra"> Optómetra</label>
            <select class="form-select" name="optometra" id="optometra"></select>
            <div style="margin-left: 100%;"></div>
            <label for="comentarios">Comentarios:</label>
            <textarea id="comentarios" name="comentarios"></textarea>

            <div style="margin-left: 100%;"></div>

            <!-- Botón de guardar -->
            <input type="submit" value="Registrar" style="align-self: flex-start;">
            
        </form>
    </div>


    <script>

        //SCRIPT PARA TRAER LOS NOMBRES DE OPTOMETRAS
        window.addEventListener('DOMContentLoaded', function () {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'busqopto.php', true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    var select = document.getElementById('optometra');
                    select.innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        });

    </script>
    <script>
        //VERIFICA QUE EXISTA EL CLIENTE
        var idClienteInput = document.getElementById('idcliente');
        var iconoValidacion = document.getElementById('icono-validacion');

        idClienteInput.addEventListener('input', function () {
            var idCliente = idClienteInput.value;

            // Verificar si el valor del campo no está vacío
            if (idCliente.trim() !== '') {
                // Realizar la solicitud AJAX
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'verificar_cliente.php?id=' + idCliente, true);
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        var respuesta = JSON.parse(xhr.responseText);
                        console.log(respuesta); // Imprime la respuesta en la consola
                        // Actualizar el icono de validación
                        if (respuesta.existe) {
                            iconoValidacion.innerHTML = '<i class="fas fa-check-circle" style="color:green;"></i>';
                        } else {
                            iconoValidacion.innerHTML = '<i class="fas fa-times-circle" style="color:red;"></i>';
                        }
                    }
                };
                xhr.send();
            } else {
                // Si el campo está vacío, elimina el icono de validación
                iconoValidacion.innerHTML = '';
            }
        });

    </script>
    <script>
        //VERIFIICAR QUE EL CUPO EXISTA
        var cupoInput = document.getElementById('cupolente');
var cupoValidacion = document.getElementById('cupo-validacion');

cupoInput.addEventListener('input', function () {
    var cupo = cupoInput.value;

    // Verificar si el valor del campo no está vacío
    if (cupo.trim() !== '') {
        // Realizar la solicitud AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'verificar_cupo.php?cupo=' + cupo, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                var respuesta = JSON.parse(xhr.responseText);
                console.log(respuesta); // Imprime la respuesta en la consola
                // Actualizar el mensaje de validación
                if (respuesta.disponible) {
                    cupoValidacion.textContent = 'Cupo disponible';
                    cupoValidacion.style.color = 'green';
                } else {
                    cupoValidacion.textContent = 'Cupo ocupado';
                    cupoValidacion.style.color = 'red';
                }
            }
        };
        xhr.send();
    } else {
        // Si el campo está vacío, elimina el mensaje de validación
        cupoValidacion.textContent = '';
    }
});

        </script>


</body>

</html>