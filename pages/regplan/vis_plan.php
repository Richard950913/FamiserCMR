<?php
include ("../../conn/conexion.php");

// Verificar si se proporcionó un ID de cliente válido en la URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $cupoplan = $_GET['id'];

    // Obtener los datos del cliente desde la base de datos 
    $sql = "SELECT * FROM compra_plan WHERE cupoplan = '$cupoplan'";
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
            <title>Editar Plan</title>
            <link rel="stylesheet" href="../../styles/styleplan.css">
        </head>

        <body>
            <div class="container">
                <h2>Credencial de Descuentos</h2>
                <form method="post" action="act_plan.php" id="editarForm">
                    <label for="cupoplan">CUPO:</label>
                    <input type="number" class="main" id="cupoplan" name="cupoplan" min="1" pattern="^[0-9]+"
                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                        maxlength="11" required value="<?php echo $row['cupoplan']; ?>">

                    <span id="cupo-validacion"></span>

                    <div style="display: block;">
                        <label for="estado">Estado:</label>
                        <select class="form-select main" name="estado" value="<?php echo $row['estado']; ?>" id="estado"
                            required>
                            <option value="PENDIENTE">Pendiente</option>
                            <option value="CANCELADO">Cancelado</option>
                            <option value="DEVOLUCION">Devolución</option>
                        </select>
                        <label for="fecha_vinc">Fecha de vinculación:</label>
                        <input class="form-select main" class="main" type="date" id="fecha_vinc" name="fecha_vinc" required
                            value="<?php echo $row['fecha_vinc']; ?>">
                        <label for="tipo_plan">Tipo de plan:</label>
                        <select class="form-select main" name="tipo_plan" id="tipo_plan" required
                            onchange="mostrarCamposAdicionales()" value="<?php echo $row['tipo_plan']; ?>">
                            <option value="1">Plan 1</option>
                            <option value="2">Plan 2</option>
                            <option value="3">Plan 3</option>
                        </select>
                        <div style="display: block;">
                            <label for="id_titular">ID del titular:</label>
                            <input type="number" class="main" id="id_titular" name="id_titular" required
                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                maxlength="15" value="<?php echo $row['id_titular']; ?>">

                            <span id="icono-validacion"></span> <!-- Aquí se mostrará el icono de verificación o X -->
                            <div style="display: block;">
                                <label for="valor_total">Valor total:</label>
                                <input type="number" class="main" id="valor_total" name="valor_total" min="1" pattern="^[0-9]+"
                                    value="<?php echo $row['valor_total']; ?>">

                                <label for="forma_pago">Forma de pago:</label>
                                <select class="form-select main" name="forma_pago" id="forma_pago" required
                                    value="<?php echo $row['forma_pago']; ?>">
                                    <option value="CONTADO">Contado</option>
                                    <option value="CREDITO">Crédito</option>
                                </select>
                                <div style="margin-left: 100%;"></div>
                                <!-- Persona 1 -->
                                <label for="nombres1">Persona 1:</label>
                                <input type="text" id="nombres1" name="nombres1" value="<?php echo $row['nombres1']; ?>">
                                <label for="fec_nac1">Fecha de nacimiento 1:</label>
                                <input class="form-select" type="date" id="fec_nac1" name="fec_nac1"
                                    value="<?php echo $row['fec_nac1']; ?>">
                                <label for="parent1">Parentesco 1:</label>
                                <input type="text" id="parent1" name="parent1" value="<?php echo $row['parent1']; ?>">
                                <div style="margin-left: 100%;"></div>
                                <!-- Persona 2 -->
                                <label for="nombres2">Persona 2:</label>
                                <input type="text" id="nombres2" name="nombres2"
                                    value="<?php echo isset($row['nombres2']) ? $row['nombres2'] : ''; ?>">
                                <label for="fec_nac2">Fecha de nacimiento 2:</label>
                                <input class="form-select" type="date" id="fec_nac2" name="fec_nac2"
                                    value="<?php echo isset($row['fec_nac2']) ? $row['fec_nac2'] : ''; ?>">
                                <label for="parent2">Parentesco 2:</label>
                                <input type="text" id="parent2" name="parent2"
                                    value="<?php echo isset($row['parent2']) ? $row['parent2'] : ''; ?>">
                                <div style="margin-left: 100%;"></div>

                                <!-- Persona 3 -->
                                <label for="nombres3">Persona 3:</label>
                                <input type="text" id="nombres3" name="nombres3"
                                    value="<?php echo isset($row['nombres3']) ? $row['nombres3'] : ''; ?>">
                                <label for="fec_nac3">Fecha de nacimiento 3:</label>
                                <input class="form-select" type="date" id="fec_nac3" name="fec_nac3"
                                    value="<?php echo isset($row['fec_nac3']) ? $row['fec_nac3'] : ''; ?>">
                                <label for="parent3">Parentesco 3:</label>
                                <input type="text" id="parent3" name="parent3"
                                    value="<?php echo isset($row['parent3']) ? $row['parent3'] : ''; ?>">
                                <div style="margin-left: 100%;"></div>

                                <div class="extra-personas">
                                    <!-- Persona 4 -->
                                    <label for="nombres4">Persona 4:</label>
                                    <input type="text" id="nombres4" name="nombres4"
                                        value="<?php echo isset($row['nombres4']) ? $row['nombres4'] : ''; ?>">
                                    <label for="fec_nac4">Fecha de nacimiento 4:</label>
                                    <input class="form-select" type="date" id="fec_nac4" name="fec_nac4"
                                        value="<?php echo isset($row['fec_nac4']) ? $row['fec_nac4'] : ''; ?>">
                                    <label for="parent4">Parentesco 4:</label>
                                    <input type="text" id="parent4" name="parent4"
                                        value="<?php echo isset($row['parent4']) ? $row['parent4'] : ''; ?>">
                                    <div style="margin-left: 100%;"></div>

                                    <!-- Persona 5 -->
                                    <label for="nombres5">Persona 5:</label>
                                    <input type="text" id="nombres5" name="nombres5"
                                        value="<?php echo isset($row['nombres5']) ? $row['nombres5'] : ''; ?>">
                                    <label for="fec_nac5">Fecha de nacimiento 5:</label>
                                    <input class="form-select" type="date" id="fec_nac5" name="fec_nac5"
                                        value="<?php echo isset($row['fec_nac5']) ? $row['fec_nac5'] : ''; ?>">
                                    <label for="parent5">Parentesco 5:</label>
                                    <input type="text" id="parent5" name="parent5"
                                        value="<?php echo isset($row['parent5']) ? $row['parent5'] : ''; ?>">
                                    <div style="margin-left: 100%;"></div>

                                    <!-- Persona 6 -->
                                    <label for="nombres6">Persona 6:</label>
                                    <input type="text" id="nombres6" name="nombres6"
                                        value="<?php echo isset($row['nombres6']) ? $row['nombres6'] : ''; ?>">
                                    <label for="fec_nac6">Fecha de nacimiento 6:</label>
                                    <input class="form-select" type="date" id="fec_nac6" name="fec_nac6"
                                        value="<?php echo isset($row['fec_nac6']) ? $row['fec_nac6'] : ''; ?>">
                                    <label for="parent6">Parentesco 6:</label>
                                    <input type="text" id="parent6" name="parent6"
                                        value="<?php echo isset($row['parent6']) ? $row['parent6'] : ''; ?>">
                                    <div style="margin-left: 100%;"></div>

                                    <!-- Persona 7 -->
                                    <label for="nombres7">Persona 7:</label>
                                    <input type="text" id="nombres7" name="nombres7"
                                        value="<?php echo isset($row['nombres7']) ? $row['nombres7'] : ''; ?>">
                                    <label for="fec_nac7">Fecha de nacimiento 7:</label>
                                    <input class="form-select" type="date" id="fec_nac7" name="fec_nac7"
                                        value="<?php echo isset($row['fec_nac7']) ? $row['fec_nac7'] : ''; ?>">
                                    <label for="parent7">Parentesco 7:</label>
                                    <input type="text" id="parent7" name="parent7"
                                        value="<?php echo isset($row['parent7']) ? $row['parent7'] : ''; ?>">
                                    <div style="margin-left: 100%;"></div>
                                </div>


                                <label for="comentarios">Comentarios:</label>
                                <textarea id="comentarios"
                                    name="comentarios"><?php echo isset($row['comentarios']) ? $row['comentarios'] : ''; ?></textarea>

                                <div style="display: block;">
                                    <label for="empresa" id="empresaLabel" style="display: none;">Empresa:</label>
                                    <input type="text" id="empresa" name="empresa" style="display: none;"
                                        value="<?php echo isset($row['empresa']) ? $row['empresa'] : ''; ?>">


                                    <!-- Contenedor para mostrar mensajes -->
                                    <div id="mensaje-container"></div>
                                    <div style="display: block;"></div>
                                    <!-- Botones: Guardar y Limpiar -->
                                    <div style="margin-left: 100%;"></div>
                                    <input type="submit" value="Actualizar" class="btn-registrar">
                                    

        </body>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="js/main2.js"></script>
        <script src="js/DOM.js"></script>

        </html>
        <?php
    } else {
        echo "No se encontró ningún plan con el cupo proporcionado.";
    }
} else {
    echo "No se proporcionó un CUPO de plan válido.";
}
?>