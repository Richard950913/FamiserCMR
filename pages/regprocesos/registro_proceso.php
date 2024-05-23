<?php


header('Content-Type: application/json');

// Verificar si se recibieron datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir archivo de conexión a la base de datos
    include("../../conn/conexion.php");
    include("../../conn/sesion.php");

    // Obtener los datos del formulario
    $cupo_id = $_POST['cupo_id'];
    $fec_mand = $_POST['fec_mand'];
    $num_talonario = strtoupper($_POST['num_talonario']);
    $proceso = $_POST['proceso'];
    $despach_por = strtoupper($_POST['despach_por']);
    $si_garantia = $_POST['si_garantia'];
    
    // Preparar la consulta SQL
    $sql = "INSERT INTO proceso_gafas (cupo_id, fec_mand, num_talonario, proceso, despach_por, si_garantia) 
    VALUES (?, ?, ?, ?, ?, ?)";
    
    // Preparar la sentencia
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        // Vincular parámetros a la consulta
        mysqli_stmt_bind_param($stmt, "isssss", $cupo_id, $fec_mand, $num_talonario, $proceso, $despach_por, 
        $si_garantia);
        
        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            // Registro en la tabla de auditoría
            $usuario = $username; // Obtén el nombre de usuario actual desde la sesión
            $tabla_afectada = "proceso_gafas"; // Nombre de la tabla afectada
            $accion = "inserción"; // Acción realizada
            $detalle_cambio = "Proceso registrado, cupo de lentes # ". $cupo_id; // Detalle de la acción
            
            // Insertar el registro en la tabla de auditoría
            $sql_auditoria = "INSERT INTO auditoria_registros (tabla_afectada, accion, usuario, detalle_cambio) 
                              VALUES (?, ?, ?, ?)";
            
            $stmt_auditoria = mysqli_prepare($conn, $sql_auditoria);
            if ($stmt_auditoria) {
                mysqli_stmt_bind_param($stmt_auditoria, "ssss", $tabla_afectada, $accion, $usuario, $detalle_cambio);
                mysqli_stmt_execute($stmt_auditoria);
            }
            
            $response = array("success" => true, "message" => "Registro de lentes exitoso.");
            echo json_encode($response);
        } else {
            // Verificar si el error es debido a una violación de clave única (cupo duplicado)
            if (mysqli_errno($conn) == 1062) {
                $response = array("success" => false, "message" => "Error: El cupo proporcionado ya está en uso.");
            } else {
                $response = array("success" => false, "message" => "Error al registrar el proceso: " . mysqli_error($conn));
            }
            echo json_encode($response);
        }
    }
}
?>
