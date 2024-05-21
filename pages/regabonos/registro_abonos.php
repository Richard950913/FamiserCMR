<?php

// Verificar si se recibieron datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir archivo de conexión a la base de datos
    include("../../conn/conexion.php");
    include("../../conn/sesion.php");

    // Obtener los datos del formulario
    $fec_abono = $_POST['fec_abono'];
    $producto = $_POST['producto'];
    $cupolentes = (!empty($_POST['cupolentes'])) ? $_POST['cupolentes'] : NULL;
    $cupoplan = (!empty($_POST['cupoplan'])) ? $_POST['cupoplan'] : NULL;
    $tipo_abono = $_POST['tipo_abono'];
    $num_recibo = strtoupper($_POST['num_recibo']);
    $valor = $_POST['valor'];
    $cod_cobrador = $_POST['cod_cobrador'];


    // Preparar la consulta SQL
    $sql = "INSERT INTO abonos (fec_abono, producto, cupolentes, cupoplan, tipo_abono, num_recibo, 
    valor, cod_cobrador) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    // Preparar la sentencia
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        // Vincular parámetros a la consulta
        mysqli_stmt_bind_param($stmt, "ssiissii", $fec_abono, $producto, $cupolentes, $cupoplan, $tipo_abono, 
        $num_recibo, $valor, $cod_cobrador);
        
        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            // Registro en la tabla de auditoría
            $usuario = $username; // Obtén el nombre de usuario actual desde la sesión
            $tabla_afectada = "abonos"; // Nombre de la tabla afectada
            $accion = "inserción"; // Acción realizada
            $detalle_cambio = "Nuevo abono, Producto # ". $producto . "cupo # " . $cupolentes . $cupoplan; // Detalle de la acción
            
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
                $response = array("success" => false, "message" => "Error al registrar el abono: " . mysqli_error($conn));
            }
            echo json_encode($response);
        }
    }
}
?>
