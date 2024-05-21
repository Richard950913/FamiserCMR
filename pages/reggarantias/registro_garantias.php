<?php


header('Content-Type: application/json');

// Verificar si se recibieron datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir archivo de conexión a la base de datos
    include("../../conn/conexion.php");
    include("../../conn/sesion.php");

    // Obtener los datos del formulario
    $cupo = $_POST['cupo'];
    $fec_gar = $_POST['fec_gar'];
    $estado_gar = $_POST['estado_gar'];
    $tipo_garantia = $_POST['tipo_garantia'];
    $nuev_form = strtoupper($_POST['nuev_form']);
    $nuev_opt = strtoupper($_POST['nuev_opt']);
    $comentarios = $_POST['comentarios'];

    // Preparar la consulta SQL
    $sql = "INSERT INTO garantias (cupo, fec_gar, estado_gar, tipo_garantia, nuev_form, nuev_opt, comentarios) 
    VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    // Preparar la sentencia
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        // Vincular parámetros a la consulta
        mysqli_stmt_bind_param($stmt, "issssss", $cupo, $fec_gar, $estado_gar, $tipo_garantia, $nuev_form, 
        $nuev_opt, $comentarios);
        
        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            // Registro en la tabla de auditoría
            $usuario = $username; // Obtén el nombre de usuario actual desde la sesión
            $tabla_afectada = "garantias"; // Nombre de la tabla afectada
            $accion = "inserción"; // Acción realizada
            $detalle_cambio = "Nueva garantia, cupo de lentes # ". $cupo . ". Tipo de garantia: ". $tipo_garantia; // Detalle de la acción
            
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
                $response = array("success" => false, "message" => "Error al registrar la garantia: " . mysqli_error($conn));
            }
            echo json_encode($response);
        }
    }
}
?>
