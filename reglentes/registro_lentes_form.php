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
    <form method="post" id="registro-form"> <!-- Agregué el atributo method="post" -->
        <label for="cupolente"># de cupo:</label>
        <input type="number" id="cupolente" name="cupolente" required
            oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
            maxlength="5">

        <span id="cupo-validacion"></span>
        <div style="margin-left: 100%;"></div>

        <label for="estado">Estado:</label>
        <select class="form-select" name="estado" id="estado" required>
            <option value="PENDIENTE">Pendiente</option>
            <option value="CANCELADO">Cancelado</option>
            <option value="DEVOLUCION">Devolución</option>
        </select>
        <label for="idcliente">Id cliente:</label>
        <input type="number" id="idcliente" name="idcliente" required
            oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
            maxlength="15">

        <span id="icono-validacion"></span> <!-- Aquí se mostrará el icono de verificación o X -->

        <label for="fec_compra">Fecha de compra:</label>
        <input class="form-select" type="date" id="fec_compra" name="fec_compra" required>
        <label for="tipo_lente">Tipo de lente:</label>
        <select class="form-select" name="tipo_lente" id="tipo_lente">
            <option value=""></option>
            <option value="M + ">M</option>
            <option value="B + ">B</option>
            <option value="P + ">P</option>
        </select>
        <label for="filtro">Filtro:</label>
        <select class="form-select" name="filtro" id="filtro">
            <option value=""></option>
            <option value="AR ">AR</option>
            <option value="BLUE ">BLUE</option>
            <option value="FOTO + BLUE ">FOTO + BLUE</option>
            <option value="FOTO ">FOTO</option>
            <option value="TRANSITION ">TRANSITION</option>
        </select>
        <label for="graduacion">Graduacióm:</label>
        <select class="form-select" name="graduacion" id="graduacion">
            <option value=""></option>
            <option value="1">1</option>
            <option value="2">2</option>
        </select>
        <label for="comp_adic">Compras adicionales:</label>
        <select class="form-select" name="comp_adic" id="comp_adic">
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
            <option value="CONTADO">CONTADO</option>
            <option value="CREDITO">CREDITO</option>
            <option value="SISTECREDITO">SISTECREDITO</option>
        </select>
        <div style="margin-left: 100%;"></div>
        <label for="formula">FÓRMULA:</label>
        <input type="text" id="formula" name="formula" style="width: 70%;" required>
        <label for="optometra"> Optómetra</label>
        <select class="form-select" name="optometra" id="optometra"></select>
        <div style="margin-left: 100%;"></div>
        <label for="comentarios">Comentarios:</label>
        <textarea id="comentarios" name="comentarios"></textarea>

        <div style="margin-left: 100%;"></div>

        <!-- Botón de guardar -->
        <input type="submit" value="Registrar"> 
        <div id="mensaje-container"></div>
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
    <script>
    // Función para limpiar los campos del formulario
    function limpiarCampos() {
        document.getElementById('cupolente').value = '';
        document.getElementById('estado').value = 'PENDIENTE'; // Reinicia el valor del estado
        document.getElementById('idcliente').value = '';
        document.getElementById('fec_compra').value = '';
        document.getElementById('tipo_lente').value = '';
        document.getElementById('filtro').value = '';
        document.getElementById('graduacion').value = '';
        document.getElementById('comp_adic').value = '';
        document.getElementById('valor_total').value = '';
        document.getElementById('sist_pago').value = 'CONTADO'; // Reinicia el valor del sistema de pago
        document.getElementById('formula').value = '';
        document.getElementById('optometra').value = '';
        document.getElementById('comentarios').value = '';
    }

    // Función para manejar la respuesta del servidor después de registrar los lentes
    function handleRegistroResponse(xhr) {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            var mensajeContainer = document.getElementById('mensaje-container');
            if (response.success) {
                mensajeContainer.innerHTML = 'Compra de lentes registrada correctamente.';
                mensajeContainer.className = 'mensaje-exito';
                limpiarCampos(); // Llamar a la función para limpiar los campos
                // Desaparecer el mensaje después de 5 segundos
                setTimeout(function () {
                    mensajeContainer.innerHTML = '';
                }, 5000);
            } else {
                if (response.message.includes('Duplicate entry')) {
                    mensajeContainer.innerHTML = 'Error: Ya existe un registro con ese número de cupo.';
                } else {
                    mensajeContainer.innerHTML = 'Error: ' + response.message;
                }
                mensajeContainer.className = 'mensaje-error';
            }
        } else {
            console.error('Error en la solicitud AJAX: ' + xhr.status);
        }
    }

    // Función para mostrar un mensaje flotante
    function mostrarMensaje(mensaje) {
        var mensajeFlotante = document.createElement('div');
        mensajeFlotante.className = 'mensaje-flotante';
        mensajeFlotante.textContent = mensaje;

        // Agregar el mensaje justo debajo del campo de ID cliente
        var idClienteInput = document.getElementById('idcliente');
        idClienteInput.parentNode.insertBefore(mensajeFlotante, idClienteInput.nextSibling);

        // Después de 3 segundos, eliminar el mensaje flotante
        setTimeout(function () {
            mensajeFlotante.parentNode.removeChild(mensajeFlotante);
        }, 3000);
    }

    // Evento para enviar el formulario y registrar los lentes
    document.getElementById('registro-form').addEventListener('submit', function (event) {
        event.preventDefault(); // Evitar el envío del formulario por defecto

        // Obtener el indicador de validación del ID cliente
        var iconoValidacion = document.getElementById('icono-validacion');

        // Verificar si el indicador está en rojo (cliente no existente)
        if (iconoValidacion.innerHTML === '<i class="fas fa-times-circle" style="color:red;"></i>') {
            mostrarMensaje('El ID proporcionado no es un cliente existente.');
        } else {
            // Si el indicador está en verde (cliente existente), enviar el formulario normalmente
            var formData = new FormData(this);
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'registrar_lentes.php', true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    handleRegistroResponse(xhr); // Manejar la respuesta del servidor
                }
            };
            xhr.send(formData);
        }
    });
</script>






</body>

</html>