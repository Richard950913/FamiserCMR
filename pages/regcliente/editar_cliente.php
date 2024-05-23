<?php
include("../../conn/conexion.php");
include("../../conn/vr_lector.php"); // Asegúrate de que la ruta sea correcta

// Verificar si se proporcionó un ID de cliente válido en la URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $cliente_id = $_GET['id'];

    // Obtener los datos del cliente desde la base de datos
    $sql = "SELECT * FROM clientes WHERE idclientes = '$cliente_id'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $numID = $row['numID'];
        
        // Consulta para verificar compras de lentes
        $sql_lentes = "SELECT cupolente, fec_compra FROM compra_lentes WHERE idcliente = '$numID'";
        $resultado_lentes = $conn->query($sql_lentes);

        // Consulta para verificar compras de credencial
        $sql_plan = "SELECT cupoplan, fecha_vinc FROM compra_plan WHERE id_titular = '$numID'";
        $resultado_plan = $conn->query($sql_plan);
        ?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Editar Cliente</title>
            <link rel="stylesheet" href="../../styles/stylevisualizar.css">
        </head>

        <body>
            <div class="container">
                <h2>Visualizar Cliente: <?php echo $row['nombresCL']; ?></h2>
                <form method="post" action="act_cliente.php" id="editarForm">
                    <input type="hidden" name="id" value="<?php echo $row['idclientes']; ?>">
                    <!-- Mostrar los datos del cliente para su edición -->

                    <label for="tipoID">Tipo de ID:</label>
                    <select class="form-select main" id="tipoID" name="tipoID" <?php echo $solo_lectura ? 'disabled' : ''; ?> required>
                        <option value="C.C" <?php echo $row['tipoID'] == 'C.C' ? 'selected' : ''; ?>>C.C</option>
                        <option value="C.E" <?php echo $row['tipoID'] == 'C.E' ? 'selected' : ''; ?>>C.E</option>
                        <option value="T.I" <?php echo $row['tipoID'] == 'T.I' ? 'selected' : ''; ?>>T.I</option>
                        <option value="Pasaporte" <?php echo $row['tipoID'] == 'Pasaporte' ? 'selected' : ''; ?>>Pasaporte</option>
                        <option value="Otro" <?php echo $row['tipoID'] == 'Otro' ? 'selected' : ''; ?>>Otro</option>
                    </select>

                    <label for="numID">Número de ID:</label>
                    <input type="text" id="numID" name="numID" value="<?php echo $row['numID']; ?>" <?php echo $solo_lectura ? 'readonly' : ''; ?> required><br>

                    <label for="nombresCL">Nombres:</label>
                    <input type="text" id="nombresCL" name="nombresCL" value="<?php echo $row['nombresCL']; ?>" <?php echo $solo_lectura ? 'readonly' : ''; ?> required><br>

                    <label for="sexo">Sexo:</label>
                    <select name="sexo" class="form-select main" id="sexo" <?php echo $solo_lectura ? 'disabled' : ''; ?> required>
                        <option value="F" <?php echo $row['sexo'] == 'F' ? 'selected' : ''; ?>>F</option>
                        <option value="M" <?php echo $row['sexo'] == 'M' ? 'selected' : ''; ?>>M</option>
                    </select>

                    <label for="lugar">Lugar:</label>
                    <input type="text" id="lugar" name="lugar" value="<?php echo $row['lugar']; ?>" <?php echo $solo_lectura ? 'readonly' : ''; ?> required><br>

                    <label for="telefono1">Teléfono 1:</label>
                    <input type="text" id="telefono1" name="telefono1" value="<?php echo $row['telefono1']; ?>" <?php echo $solo_lectura ? 'readonly' : ''; ?>><br>

                    <label for="telefono2">Teléfono 2:</label>
                    <input type="text" id="telefono2" name="telefono2" value="<?php echo $row['telefono2']; ?>" <?php echo $solo_lectura ? 'readonly' : ''; ?>><br>

                    <label for="direccion">Dirección:</label>
                    <input type="text" id="direccion" name="direccion" value="<?php echo $row['direccion']; ?>" <?php echo $solo_lectura ? 'readonly' : ''; ?>><br>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" <?php echo $solo_lectura ? 'readonly' : ''; ?>><br>
                    <span id="emailError" style="color: red;"></span><br>

                    <label for="fec_nac">Fecha de nacimiento:</label>
                    <input type="date" class="form-select" id="fec_nac" name="fec_nac" value="<?php echo $row['fec_nac']; ?>" <?php echo $solo_lectura ? 'readonly' : ''; ?>><br>

                    <label for="oficio">Oficio:</label>
                    <input type="text" id="oficio" name="oficio" value="<?php echo $row['oficio']; ?>" <?php echo $solo_lectura ? 'readonly' : ''; ?>><br>

                    <label for="empresa">Empresa:</label>
                    <input type="text" id="empresa" name="empresa" value="<?php echo $row['empresa']; ?>" <?php echo $solo_lectura ? 'readonly' : ''; ?>><br>

                    <div id="acudienteContainer" style="display: none;">
                        <label for="acudiente">Acudiente:</label>
                        <input type="text" id="acudiente" name="acudiente" value="<?php echo $row['acudiente']; ?>" style="width:60%" <?php echo $solo_lectura ? 'readonly' : ''; ?>><br>
                    </div>
                    <?php if (!$solo_lectura) { ?>
                        <input type="submit" value="Actualizar" class="btn-registrar">
                    <?php } ?>
                </form>
            </div>

            <div class="container">
            <h2>COMPRA DE LENTES</h2>
                <?php
                if ($resultado_lentes->num_rows > 0) {
                    while ($row_lentes = $resultado_lentes->fetch_assoc()) {
                        echo '<p><a href="detalle_lente.php?id=' . $row_lentes['cupolente'] . '">' . $row_lentes['cupolente'] . '</a> - ' . $row_lentes['fec_compra'] . '</p>';
                    }
                } else {
                    echo '<p>El usuario no ha registrado compras de lentes.</p>';
                }
                ?>
            </div>
    
                <div class="container">
                    <h2>COMPRA DE CREDENCIAL</h2>
                    <?php
                    if ($resultado_plan->num_rows > 0) {
                        while ($row_plan = $resultado_plan->fetch_assoc()) {
                            echo '<p><a href="detalle_plan.php?id=' . $row_plan['cupoplan'] . '">' . $row_plan['cupoplan'] . '</a> - ' . $row_plan['fecha_vinc'] . '</p>';
                        }
                    } else {
                        echo '<p>El usuario no ha registrado compras de credenciales.</p>';
                    }
                    ?>
                </div>
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
    
