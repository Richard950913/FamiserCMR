<?php
include ("../../conn/conexion.php");
include ("../../conn/sesion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $cupoplan = strtoupper(!empty($_POST['cupoantiguo']) ? $_POST['cupoantiguo'] : null);
    $cuponuevo = $_POST['cupoplan'];
    $estado = strtoupper(!empty($_POST['estado']) ? $_POST['estado'] : null);
    $fecha_vinc = $_POST['fecha_vinc'];
    $tipo_plan = $_POST['tipo_plan'];
    $id_titular = $_POST['id_titular'];
    $valor_total = $_POST['valor_total'];
    $forma_pago = $_POST['forma_pago'];
    $nombres1 = strtoupper(!empty($_POST['nombres1']) ? $_POST['nombres1'] : null);
    $fec_nac1 = $_POST['fec_nac1'];
    $parent1 = strtoupper(!empty($_POST['parent1']) ? $_POST['parent1'] : null);
    $nombres2 = strtoupper(!empty($_POST['nombres2']) ? $_POST['nombres2'] : null);
    $fec_nac2 = $_POST['fec_nac2'];
    $parent2 = strtoupper(!empty($_POST['parent2']) ? $_POST['parent2'] : null);
    $nombres3 = strtoupper(!empty($_POST['nombres3']) ? $_POST['nombres3'] : null);
    $fec_nac3 = $_POST['fec_nac3'];
    $parent3 = strtoupper(!empty($_POST['parent3']) ? $_POST['parent3'] : null);
    $nombres4 = strtoupper(!empty($_POST['nombres4']) ? $_POST['nombres4'] : null);
    $fec_nac4 = $_POST['fec_nac4'];
    $parent4 = strtoupper(!empty($_POST['parent4']) ? $_POST['parent4'] : null);
    $nombres5 = strtoupper(!empty($_POST['nombres5']) ? $_POST['nombres5'] : null);
    $fec_nac5 = $_POST['fec_nac5'];
    $parent5 = strtoupper(!empty($_POST['parent5']) ? $_POST['parent5'] : null);
    $nombres6 = strtoupper(!empty($_POST['nombres6']) ? $_POST['nombres6'] : null);
    $fec_nac6 = $_POST['fec_nac6'];
    $parent6 = strtoupper(!empty($_POST['parent6']) ? $_POST['parent6'] : null);
    $nombres7 = strtoupper(!empty($_POST['nombres7']) ? $_POST['nombres7'] : null);
    $fec_nac7 = $_POST['fec_nac7'];
    $parent7 = strtoupper(!empty($_POST['parent7']) ? $_POST['parent7'] : null);
    $comentarios = strtoupper(!empty($_POST['comentarios']) ? $_POST['comentarios'] : null);
    $empresa = strtoupper(!empty($_POST['empresa']) ? $_POST['empresa'] : null);

    // Obtener el nombre de usuario actual
    $usuario = $username;

    // Preparar la consulta SQL para verificar el titular
    $sql_verificar_cliente = "SELECT numID FROM clientes WHERE numID = '$id_titular'";
    $resultado_verificacion = $conn->query($sql_verificar_cliente);

    if ($resultado_verificacion === false || $resultado_verificacion->num_rows === 0) {
        // Error al ejecutar la consulta o no se encontró el titular
        echo '<div id="mensaje-error" style="color: red;">No se puede actualizar un plan con un ID de TITULAR que no exista en la tabla CLIENTES</div>';
        echo '<button onclick="regresar()">Regresar</button>';
    } else {
        // Consulta SQL para actualizar el registro
        if (!empty($cuponuevo)) {
            // Si $cuponuevo tiene un valor, actualiza todos los campos incluyendo cupoplan
            $sql_update_plan = "UPDATE compra_plan SET 
                                    cupoplan = '$cuponuevo',
                                    estado = '$estado', 
                                    fecha_vinc = '$fecha_vinc', 
                                    tipo_plan = '$tipo_plan', 
                                    id_titular = '$id_titular', 
                                    valor_total = '$valor_total', 
                                    forma_pago = '$forma_pago', 
                                    nombres1 = '$nombres1', 
                                    fec_nac1 = '$fec_nac1', 
                                    parent1 = '$parent1', 
                                    nombres2 = '$nombres2', 
                                    fec_nac2 = '$fec_nac2', 
                                    parent2 = '$parent2',
                                    nombres3 = '$nombres3', 
                                    fec_nac3 = '$fec_nac3', 
                                    parent3 = '$parent3',
                                    nombres4 = '$nombres4', 
                                    fec_nac4 = '$fec_nac4', 
                                    parent4 = '$parent4',
                                    nombres5 = '$nombres5', 
                                    fec_nac5 = '$fec_nac5', 
                                    parent5 = '$parent5',
                                    nombres6 = '$nombres6', 
                                    fec_nac6 = '$fec_nac6', 
                                    parent6 = '$parent6',
                                    nombres7 = '$nombres7', 
                                    fec_nac7 = '$fec_nac7', 
                                    parent7 = '$parent7',
                                    comentarios = '$comentarios',
                                    empresa = '$empresa'
                                WHERE cupoplan = '$cupoplan'";
        } else {
            // Si $cuponuevo está vacío, actualiza todos los campos excepto cupoplan
            $sql_update_plan = "UPDATE compra_plan SET 
                                    estado = '$estado', 
                                    fecha_vinc = '$fecha_vinc', 
                                    tipo_plan = '$tipo_plan', 
                                    id_titular = '$id_titular', 
                                    valor_total = '$valor_total', 
                                    forma_pago = '$forma_pago', 
                                    nombres1 = '$nombres1', 
                                    fec_nac1 = '$fec_nac1', 
                                    parent1 = '$parent1', 
                                    nombres2 = '$nombres2', 
                                    fec_nac2 = '$fec_nac2', 
                                    parent2 = '$parent2',
                                    nombres3 = '$nombres3', 
                                    fec_nac3 = '$fec_nac3', 
                                    parent3 = '$parent3',
                                    nombres4 = '$nombres4', 
                                    fec_nac4 = '$fec_nac4', 
                                    parent4 = '$parent4',
                                    nombres5 = '$nombres5', 
                                    fec_nac5 = '$fec_nac5', 
                                    parent5 = '$parent5',
                                    nombres6 = '$nombres6', 
                                    fec_nac6 = '$fec_nac6', 
                                    parent6 = '$parent6',
                                    nombres7 = '$nombres7', 
                                    fec_nac7 = '$fec_nac7', 
                                    parent7 = '$parent7',
                                    comentarios = '$comentarios',
                                    empresa = '$empresa'
                                WHERE cupoplan = '$cupoplan'";
        }

        if ($conn->query($sql_update_plan) === TRUE) {
            // Registro actualizado correctamente, registrar en la tabla de auditoría
            $accion = "modificación";
            $tabla_afectada = "Compra_plan";
            $detalle_cambio = "Plan actualizado: $cupoplan (Titular: $id_titular)";

            // Consulta SQL para insertar registro de auditoría
            $sql_insert_auditoria = "INSERT INTO auditoria_registros (tabla_afectada, accion, usuario, detalle_cambio) VALUES (?, ?, ?, ?)";
            $stmt_insert_auditoria = $conn->prepare($sql_insert_auditoria);
            $stmt_insert_auditoria->bind_param("ssss", $tabla_afectada, $accion, $usuario, $detalle_cambio);
            $stmt_insert_auditoria->execute();
            $stmt_insert_auditoria->close();

            echo "Registro actualizado correctamente.<br>";
            echo '<button onclick="cerrarVentana()">Cerrar</button>';
        } else {
            // Error al actualizar el registro
            echo "Error al actualizar el registro: " . $conn->error;
        }
    }

    // Cerrar la conexión
    $conn->close();
}
?>

<script>
    function cerrarVentana() {
        window.location.href = "registro_plan_form.php";
    }
    function regresar() {
        window.history.back();
    }
</script>
