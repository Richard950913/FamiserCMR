<?php
include ("../conexion.php");

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
            <link rel="stylesheet" href="../styles/style2.css">
        </head>

        <body>
            <div class="container">
                <h2>Editar Cliente</h2>
                <form method="post" action="act_cliente.php">
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

                    <label for="fec_nac">Fecha de nacimiento:</label>
                    <input type="text" id="fec_nac" name="fec_nac" value="<?php echo $row['fec_nac']; ?>"><br>

                    <label for="oficio">Oficio:</label>
                    <input type="text" id="oficio" name="oficio" value="<?php echo $row['oficio']; ?>"><br>

                    <label for="empresa">Empresa:</label>
                    <input type="text" id="empresa" name="empresa" value="<?php echo $row['empresa']; ?>"><br>

                    <input type="submit" value="Actualizar">
                </form>
            </div>
            <!-- Incluir el archivo de scripts -->
            <script src="scriptrc.js"></script>
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