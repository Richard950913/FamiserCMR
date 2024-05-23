<?php
include("../../conn/conexion.php");
include("../../conn/vr_opt.php");

// Verificar si se proporcionó un ID de lente válido en la URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $lente_id = $_GET['id'];

    // Obtener los datos del lente desde la base de datos
    $sql = "SELECT * FROM compra_lentes WHERE cupolente = '$lente_id'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        
        // Consulta para verificar garantías asociadas al lente
        $sql_garantias = "SELECT cupo, fec_gar FROM garantias WHERE cupo = '$lente_id'";
        $resultado_garantias = $conn->query($sql_garantias);

        // Consulta para verificar abonos asociados al lente
        $sql_abonos = "SELECT * FROM abonos WHERE cupolentes = '$lente_id'";
        $resultado_abonos = $conn->query($sql_abonos);
        ?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Editar Lente</title>
            <link rel="stylesheet" href="../../styles/stylevisualizar.css">
        </head>

        <body>
            <div class="container">
                <h2>Visualizar Lente: <?php echo $row['cupolente']; ?></h2>
                <form method="post" action="act_lente.php" id="editarForm">
                    <input type="hidden" name="id" value="<?php echo $row['cupolente']; ?>">
                    <!-- Mostrar los datos del lente para su edición -->

                    <label for="cupolente"># de cupo:</label>
                    <input type="text" id="cupolente" name="cupolente" value="<?php echo $row['cupolente']; ?>" readonly><br>

                    <label for="estado">Estado:</label>
                    <select class="form-select main" name="estado" id="estado" <?php echo $solo_lectura ? 'disabled' : ''; ?> required>
                        <option value="PENDIENTE" <?php echo $row['estado'] == 'PENDIENTE' ? 'selected' : ''; ?>>Pendiente</option>
                        <option value="CANCELADO" <?php echo $row['estado'] == 'CANCELADO' ? 'selected' : ''; ?>>Cancelado</option>
                        <option value="DEVOLUCION" <?php echo $row['estado'] == 'DEVOLUCION' ? 'selected' : ''; ?>>Devolución</option>
                    </select>

                    <label for="idcliente">Id cliente:</label>
                    <input type="text" id="idcliente" name="idcliente" value="<?php echo $row['idcliente']; ?>" readonly><br>

                    <label for="fec_compra">Fecha de compra:</label>
                    <input type="date" id="fec_compra" name="fec_compra" value="<?php echo $row['fec_compra']; ?>" <?php echo $solo_lectura ? 'readonly' : ''; ?>><br>

                    <label for="tipo_lente">Tipo de lente:</label>
                    <select class="form-select main" name="tipo_lente" id="tipo_lente" <?php echo $solo_lectura ? 'disabled' : ''; ?>>
                        <option value=""></option>
                        <option value="MONOFOCAL" <?php echo $row['tipo_lente'] == 'MONOFOCAL' ? 'selected' : ''; ?>>MONOFOCAL</option>
                        <option value="BIFOCAL" <?php echo $row['tipo_lente'] == 'BIFOCAL' ? 'selected' : ''; ?>>BIFOCAL</option>
                        <option value="POLICARBONATO" <?php echo $row['tipo_lente'] == 'POLICARBONATO' ? 'selected' : ''; ?>>POLICARBONATO</option>
                        <option value="N/A" <?php echo $row['tipo_lente'] == 'N/A' ? 'selected' : ''; ?>>N/A</option>
                    </select>

                    <!-- Mostrar garantías asociadas al lente -->
                    <div class="container">
                        <h2>GARANTÍAS</h2>
                        <?php
                        if ($resultado_garantias->num_rows > 0) {
                            while ($row_garantia = $resultado_garantias->fetch_assoc()) {
                                echo '<p><a href="detalle_garantia.php?id=' . $row_garantia['cupo'] . '">' . $row_garantia['cupo'] . '</a> - ' . $row_garantia['fecha'] . '</p>';
                            }
                        } else {
                            echo '<p>No hay garantías asociadas a este lente.</p>';
                        }
                        ?>
                    </div>

                    <!-- Mostrar abonos asociados al lente -->
                    <div class="container">
                        <h2>ABONOS</h2>
                        <table>
                            <tr>
                                <th>Cupo</th>
                                <th>Fecha de abono</th>
                                <th>Valor</th>
                            </tr>
                            <?php
                            if ($resultado_abonos->num_rows > 0) {
                                while ($row_abono = $resultado_abonos->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td>' . $row_abono['cupo'] . '</td>';
                                    echo '<td>' . $row_abono['fecha_abono'] . '</td>';
                                    echo '<td>' . $row_abono['valor'] . '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="3">No hay abonos asociados a este lente.</td></tr>';
                            }
                            ?>
                        </table>
                    </div>

                    <!-- Botón de actualizar si no es modo de solo lectura -->
                    <?php if (!$solo_lectura) { ?>
                        <input type="submit" value="Actualizar" class="btn-registrar">
                    <?php } ?>
                </form>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "No se encontró ningún lente con el ID proporcionado.";
    }
} else {
    echo "No se proporcionó un ID de lente válido.";
}?>
