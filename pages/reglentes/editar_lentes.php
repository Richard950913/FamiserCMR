<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include ("../../conn/conexion.php");
include ("../../conn/vr_opt.php");

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
                <form method="post" action="act_lentes.php" id="editarForm">
                    <input type="hidden" name="id" value="<?php echo $row['cupolente']; ?>">
                    <!-- Mostrar los datos del lente para su edición -->

                    <label for="cupolente">CUPO:</label>
                    <input type="text" id="cupolente" name="cupolente" value="<?php echo $row['cupolente']; ?>" readonly><br>

                    <label for="est_proceso">Estado:</label>
                    <select class="form-select main" name="est_proceso" id="est_proceso" <?php echo $solo_lectura ? 'disabled' : ''; ?> required>
                        <option value="PENDIENTE" <?php echo $row['est_proceso'] == 'PENDIENTE' ? 'selected' : ''; ?>>Pendiente
                        </option>
                        <option value="CANCELADO" <?php echo $row['est_proceso'] == 'CANCELADO' ? 'selected' : ''; ?>>Cancelado
                        </option>
                        <option value="DEVOLUCION" <?php echo $row['est_proceso'] == 'DEVOLUCION' ? 'selected' : ''; ?>>Devolución
                        </option>
                    </select>

                    <label for="idcliente">Id cliente:</label>
                    <input type="text" id="idcliente" name="idcliente" value="<?php echo $row['idcliente']; ?>" readonly><br>

                    <label for="fec_compra">Fecha de compra:</label>
                    <input type="date" class="form-select main" id="fec_compra" name="fec_compra"
                        value="<?php echo $row['fec_compra']; ?>" <?php echo $solo_lectura ? 'readonly' : ''; ?>><br>

                    <label for="tipo_lente">Tipo de lente:</label>
                    <input class="form-select main" name="tipo_lente" id="tipo_lente" value="<?php echo $row['tipo_lente']; ?>"
                        <?php echo $solo_lectura ? 'disabled' : ''; ?> style="width: 45%"></input>
                    <div style="display: block;"></div>

                    <label for="compra_adic">Compras adicionales:</label>
                    <select class="form-select main" name="compra_adic" id="compra_adic">
                        <option value=""></option>
                        <option value="GOTAS" <?php echo $row['compra_adic'] == 'GOTAS' ? 'selected' : ''; ?>>GOTAS</option>
                        <option value="MONTURA" <?php echo $row['compra_adic'] == 'MONTURA' ? 'selected' : ''; ?>>MONTURA</option>
                        <option value="LENTES DE CONTACTO" <?php echo $row['compra_adic'] == 'LENTES DE CONTACTO' ? 'selected' : ''; ?>>LENTES DE CONTACTO</option>
                        <option value="OTROS" <?php echo $row['compra_adic'] == 'OTROS' ? 'selected' : ''; ?>>OTROS</option>
                        <option value="N/A" <?php echo $row['compra_adic'] == 'N/A' ? 'selected' : ''; ?>>N/A</option>
                    </select>
                    <div style="display: block;"></div>
                    <label for="valor_total">Valor total:</label>
                    <input type="number" id="valor_total" name="valor_total" value="<?php echo $row['valor_total']; ?>" min="1"
                        pattern="^[0-9]+"><br>
                    <div style="display: block;"></div>
                    <label for="sist_pago">Sistema de pago:</label>
                    <select class="form-select main" name="sist_pago" id="sist_pago" required>
                        <option value="CONTADO" <?php echo $row['sist_pago'] == 'CONTADO' ? 'selected' : ''; ?>>CONTADO</option>
                        <option value="CREDITO" <?php echo $row['sist_pago'] == 'CREDITO' ? 'selected' : ''; ?>>CRÉDITO</option>
                        <option value="SISTECREDITO" <?php echo $row['sist_pago'] == 'SISTECREDITO' ? 'selected' : ''; ?>>
                            SISTECREDITO</option>
                    </select>
                    <div style="display: block;"></div>
                    <label for="formula">FÓRMULA:</label>
                    <input type="text" class="main" id="formula" name="formula" style="width: 70%;" value="<?php echo $row['formula']; ?>"
                        required><br>
                    <div style="display: block;"></div>
                    <label for="optometra">Optómetra:</label>
                    <select class="form-select main" name="optometra" id="optometra">
                        <!-- Aquí debes añadir las opciones disponibles para los optometristas -->
                    </select>
                    <div style="display: block;"></div>
                    <label for="comentarios_lt" class="main">Comentarios:</label>
                    <div style="display: block;"></div>
                    <textarea type="textarea" id="comentarios_lt" name="comentarios_lt"><?php echo $row['comentarios_lt']; ?></textarea><br>

                    <!-- Botón de actualizar si no es modo de solo lectura -->
                    <?php if (!$solo_lectura) { ?>
                        <input type="submit" value="Actualizar" class="btn-registrar">
                    <?php } ?>
                </form>
            </div>
            <div class="container">
                <!-- Mostrar garantías asociadas al lente -->
                <div class="container">
                    <h2>GARANTÍAS</h2>
                    <?php
                    if ($resultado_garantias->num_rows > 0) {
                        while ($row_garantia = $resultado_garantias->fetch_assoc()) {
                            echo '<p><a href="detalle_garantia.php?id=' . $row_garantia['cupo'] . '">' . $row_garantia['cupo'] . '</a> - ' . $row_garantia['fec_gar'] . '</p>';
                        }
                    } else {
                        echo '<p>No hay garantías asociadas a este lente.</p>';
                    }
                    ?>
                </div>
            </div>
            <!-- Mostrar abonos asociados al lente -->
            <div class="container">
                <h2>ABONOS</h2>
                <table>
                    <tr>
                        <th>Cupo</th>
                        <th>Fecha de abono</th>
                        <th>Valor</th>
                        <th>Nº Recibo</th>
                        <th>Cod. Cobrador</th>
                    </tr>
                    <?php
                    if ($resultado_abonos->num_rows > 0) {
                        while ($row_abono = $resultado_abonos->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row_abono['cupolentes'] . '</td>';
                            echo '<td>' . $row_abono['fec_abono'] . '</td>';
                            echo '<td>' . $row_abono['valor'] . '</td>';
                            echo '<td>' . $row_abono['num_recibo'] . '</td>';
                            echo '<td>' . $row_abono['cod_cobrador'] . '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5">No hay abonos asociados a este lente.</td></tr>';
                    }
                    ?>
                </table>
            </div>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="js/main.js"></script>
        </body>

        </html>
        <?php
    } else {
        echo "No se encontró ningún lente con el ID proporcionado.";
    }
} else {
    echo "No se proporcionó un ID de lente válido.";
}
?>