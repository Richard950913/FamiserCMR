<?php
include ("../../conn/conexion.php");

// Verificar si se proporcionó un ID de cliente válido en la URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $cliente_id = $_GET['id'];

    // Obtener los datos del cliente desde la base de datos
    $sql = "SELECT * FROM clientes WHERE idclientes = '$cliente_id'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        // Mostrar el formulario con los datos del cliente para su edición
        ?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Editar Cliente</title>
            <link rel="stylesheet" href="../../styles/style2.css">
        </head>

        <body>
            <div class="container">
                <h2>Editar Cliente</h2>
                <form method="post" action="act_cliente.php" id="editarForm">
                    <input type="hidden" name="id" value="<?php echo $row['idclientes']; ?>">
                    <!-- Mostrar los datos del cliente para su edición -->

                    <label for="tipoID">Tipo de ID:</label>
                    <select class="form-select" id="tipoID" name="tipoID" value="<?php echo $row['tipoID']; ?>" required>
                        <option value="C.C">C.C</option>
                        <option value="C.E">C.E</option>
                        <option value="T.I">T.I</option>
                        <option value="Pasaporte">Pasaporte</option>
                        <option value="Otro">Otro</option>
                    </select>


                    <label for="numID">Número de ID:</label>
                    <input type="text" id="numID" name="numID" value="<?php echo $row['numID']; ?>" required><br>

                    <label for="nombresCL">Nombres:</label>
                    <input type="text" id="nombresCL" name="nombresCL" value="<?php echo $row['nombresCL']; ?>" required><br>

                    <label for="sexo">Sexo:</label>
                    <select name="sexo" id="sexo" value="<?php echo $row['sexo']; ?>">
                        <option value=""></option>
                        <option value="F">F</option>
                        <option value="M">M</option>
                    </select>

                    <label for="lugar">Lugar:</label>
                    <input type="text" id="lugar" name="lugar" value="<?php echo $row['lugar']; ?>" required><br>

                    <label for="telefono1">Teléfono 1:</label>
                    <input type="text" id="telefono1" name="telefono1" value="<?php echo $row['telefono1']; ?>"><br>

                    <label for="telefono2">Teléfono 2:</label>
                    <input type="text" id="telefono2" name="telefono2" value="<?php echo $row['telefono2']; ?>"><br>

                    <label for="direccion">Dirección:</label>
                    <input type="text" id="direccion" name="direccion" value="<?php echo $row['direccion']; ?>"><br>

                    <label for="email">Email:</label>
                    <input type="text" id="email" name="email" value="<?php echo $row['email']; ?>"><br>
                    <span id="emailError" style="color: red;"></span><br>

                    <label for="fec_nac">Fecha de nacimiento:</label>
                    <input type="date" id="fec_nac" name="fec_nac" value="<?php echo $row['fec_nac']; ?>"><br>

                    <label for="oficio">Oficio:</label>
                    <input type="text" id="oficio" name="oficio" value="<?php echo $row['oficio']; ?>"><br>

                    <label for="empresa">Empresa:</label>
                    <input type="text" id="empresa" name="empresa" value="<?php echo $row['empresa']; ?>"><br>

                    <div id="acudienteContainer" style="display: none;">
                    <label for="acudiente">Acudiente:</label>
                    <input type="text" id="acudiente" name="acudiente" value="<?php echo $row['acudiente']; ?>" style="width:60%"><br>
                    </div>
                    <input type="submit" value="Actualizar">
                </form>
            </div>
            <!-- Incluir el archivo de scripts -->
            <script>
    // Función para validar el correo electrónico
    function validarEmail() {
        var emailInput = document.getElementById("email").value.trim(); // Eliminar espacios en blanco al principio y al final
        var emailError = document.getElementById("emailError");
        // Si el campo no está en blanco y no sigue un formato de correo electrónico válido, mostrar un mensaje de error
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (emailInput !== "" && !emailRegex.test(emailInput)) {
            emailError.innerText = "El email proporcionado no sigue un formato regular.";
            return false; // Evitar que se envíe el formulario
        } else {
            emailError.innerText = ""; // Limpiar el mensaje de error si el correo es válido
            return true; // Permitir el envío del formulario
        }
    }

    // Asignar la función validarEmail() al evento de envío del formulario
    document.getElementById("editarForm").addEventListener("submit", function (event) {
        if (!validarEmail()) {
            event.preventDefault(); // Detener el envío del formulario si el correo no cumple el formato
        }
    });
</script>
 <!-- verificar edad si es menor-->
 <script>
        // Función para actualizar la visibilidad del campo de acudiente según la edad
        function actualizarCampos() {
            var fechaNacimiento = document.getElementById("fec_nac").value;
            var hoy = new Date();
            var fechaNacimiento = new Date(fechaNacimiento);
            var edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
            var mes = hoy.getMonth() - fechaNacimiento.getMonth();

            if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
                edad--;
            }

            var acudienteContainer = document.getElementById("acudienteContainer");

            if (edad < 18) {
                acudienteContainer.style.display = "block";
                document.getElementById("acudiente").required = true;
            } else {
                acudienteContainer.style.display = "none";
                document.getElementById("acudiente").required = false;
                document.getElementById("acudiente").value = ""; // Limpiar el valor si se oculta
            }
        }

        // Asignar la función actualizarCampos al evento onchange del campo de fecha de nacimiento
        document.getElementById("fec_nac").addEventListener("change", actualizarCampos);

        // Llamar a la función actualizarCampos al cargar la página para asegurarse de que el campo se oculte inicialmente
        window.onload = actualizarCampos;
    </script>



        </body>

        </html>
        <?php
    } else {
        echo "No se encontró ningún cliente con el ID proporcionado.";
    }
} else {
    echo "No se proporcionó un ID de cliente válido.";
}
?>