<?php
include("../../conn/conexion.php");
include("../../conn/sesion.php");

// Verificar si se recibió el ID del plan a eliminar
if (isset($_POST['id']) && !empty($_POST['id'])) {
    $cupoplan = $_POST['id'];

    // Preparar la consulta SQL para obtener los datos del plan antes de la eliminación
    $sql_select_cupo = "SELECT * FROM compra_plan WHERE cupoplan = ?";
    $stmt_select_cupo = $conn->prepare($sql_select_cupo);
    $stmt_select_cupo->bind_param("i", $cupoplan);
    $stmt_select_cupo->execute();
    $result = $stmt_select_cupo->get_result();
    $cupo = $result->fetch_assoc();
    $stmt_select_cupo->close();

    // Realizar la eliminación del plan en la base de datos
    $sql_eliminar_cupo = "DELETE FROM compra_plan WHERE cupoplan = ?";
    $stmt_eliminar_cupo = $conn->prepare($sql_eliminar_cupo);
    $stmt_eliminar_cupo->bind_param("i", $cupoplan);

    if ($stmt_eliminar_cupo->execute()) {
        // Registro de eliminación en la tabla de auditoría
        $usuario = $username; // Obtén el nombre de usuario actual desde la sesión (verifica la forma correcta de obtenerlo)
        $tabla_afectada = "compra_plan"; // Nombre de la tabla afectada
        $accion = "Eliminación"; // Acción realizada

        // Detalles adicionales sobre el cambio
        $detalle_cambio = "Plan eliminado: CupoPlan = $cupoplan";

        // Preparar la consulta SQL para insertar el registro en la tabla de auditoría
        $sql_insert_auditoria = "INSERT INTO auditoria_registros (tabla_afectada, accion, usuario, detalle_cambio)
                                 VALUES (?, ?, ?, ?)";
        $stmt_insert_auditoria = $conn->prepare($sql_insert_auditoria);
        $stmt_insert_auditoria->bind_param("ssss", $tabla_afectada, $accion, $usuario, $detalle_cambio);
        
        // Ejecutar la inserción del registro en la tabla de auditoría
        if ($stmt_insert_auditoria->execute()) {
            $stmt_insert_auditoria->close();
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Error al registrar la auditoría: ' . $conn->error));
        }
    } else {
        echo json_encode(array('success' => false, 'message' => 'Error al eliminar el plan: ' . $conn->error));
    }

    $stmt_eliminar_cupo->close();
    $conn->close();
} else {
    echo json_encode(array('success' => false, 'message' => 'ID de plan no proporcionado.'));
}
?>
