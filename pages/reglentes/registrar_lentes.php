<?php

// Verificar si se recibieron datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir archivo de conexión a la base de datos
    include("../../conn/conexion.php");
    include("../../conn/sesion.php");

    // Obtener los datos del formulario
    $cupolente = strtoupper($_POST['cupolente']);
    $estado = strtoupper($_POST['estado']);
    $idcliente = (!empty($_POST['idcliente'])) ? $_POST['idcliente'] : NULL;
    $fec_compra = $_POST['fec_compra'];

    // Concatenar tipo_lente, filtro y graduacion en un solo campo
    $tipo_lente_completo = strtoupper($_POST['tipo_lente']) . ' ' . strtoupper($_POST['filtro']) . ' ' . strtoupper($_POST['graduacion']);

    $comp_adic = strtoupper($_POST['comp_adic']);
    $valor_total = (!empty($_POST['valor_total'])) ? $_POST['valor_total'] : NULL;
    $sist_pago = strtoupper($_POST['sist_pago']);
    $formula = strtoupper($_POST['formula']);
    $optometra = strtoupper($_POST['optometra']);
    $comentarios = $_POST['comentarios'];

    // Preparar la consulta SQL
    $sql = "INSERT INTO compra_lentes (cupolente, est_proceso, idcliente, fec_compra, tipo_lente, compra_adic, valor_total, sist_pago, formula, optometra, comentarios_lt) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    // Preparar la sentencia
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        // Vincular parámetros a la consulta
        mysqli_stmt_bind_param($stmt, "isisssissss", $cupolente, $estado, $idcliente, $fec_compra, $tipo_lente_completo, $comp_adic, $valor_total, $sist_pago, $formula, $optometra, $comentarios);
        
        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            // Registro en la tabla de auditoría
            $usuario = $username; // Obtén el nombre de usuario actual desde la sesión
            $tabla_afectada = "compra_lentes"; // Nombre de la tabla afectada
            $accion = "inserción"; // Acción realizada
            $detalle_cambio = "Nueva registro, cupo #" . $cupolente; // Detalle de la acción
            
            // Insertar el registro en la tabla de auditoría
            $sql_auditoria = "INSERT INTO auditoria_registros (tabla_afectada, accion, usuario, detalle_cambio) 
                              VALUES (?, ?, ?, ?)";
            
            $stmt_auditoria = mysqli_prepare($conn, $sql_auditoria);
            if ($stmt_auditoria) {
                mysqli_stmt_bind_param($stmt_auditoria, "ssss", $tabla_afectada, $accion, $usuario, $detalle_cambio);
                mysqli_stmt_execute($stmt_auditoria);
            }
            
            $response = array("success" => true, "message" => "Compra de lentes registrada correctamente.");
            echo json_encode($response);
        } else {
            // Verificar si el error es debido a una violación de clave única (cupo duplicado)
            if (mysqli_errno($conn) == 1062) {
                $response = array("success" => false, "message" => "Error: El cupo proporcionado ya está en uso.");
            } else {
                $response = array("success" => false, "message" => "Error al registrar la compra de lentes: " . mysqli_error($conn));
            }
            echo json_encode($response);
        }
    }
}
?>
