<?php
include("../../conn/conexion.php");
include("../../conn/sesion.php");

if (isset($_POST['id']) && !empty($_POST['id'])) {
    $cliente_id = $_POST['id'];

    // Preparar la consulta SQL para obtener los datos del cliente antes de la eliminación
    $sql_select_cliente = "SELECT * FROM clientes WHERE idclientes = ?";
    $stmt_select_cliente = $conn->prepare($sql_select_cliente);
    $stmt_select_cliente->bind_param("i", $cliente_id);
    $stmt_select_cliente->execute();
    $result = $stmt_select_cliente->get_result();
    $cliente = $result->fetch_assoc();
    $stmt_select_cliente->close();

    // Realizar la eliminación del cliente en la base de datos
    $sql_eliminar_cliente = "DELETE FROM clientes WHERE idclientes = ?";
    $stmt_eliminar_cliente = $conn->prepare($sql_eliminar_cliente);
    $stmt_eliminar_cliente->bind_param("i", $cliente_id);

    if ($stmt_eliminar_cliente->execute()) {
        // Registro de eliminación en la tabla de auditoría
        $accion = "eliminación";
        $tabla_afectada = "clientes";
        $detalle_cambio = "Cliente eliminado: " . $cliente['nombresCL'] . " (" . $cliente['numID'] . ")";
        
        // Preparar la consulta SQL para insertar el registro de auditoría
        $sql_insert_auditoria = "INSERT INTO auditoria_registros (tabla_afectada, accion, usuario, detalle_cambio) VALUES (?, ?, ?, ?)";
        $stmt_insert_auditoria = $conn->prepare($sql_insert_auditoria);
        $stmt_insert_auditoria->bind_param("ssss", $tabla_afectada, $accion, $username, $detalle_cambio);
        $stmt_insert_auditoria->execute();
        $stmt_insert_auditoria->close();

        echo json_encode(array('success' => true));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Error al eliminar el cliente.'));
    }

    $stmt_eliminar_cliente->close();
    $conn->close();
} else {
    echo json_encode(array('success' => false, 'message' => 'ID de cliente no proporcionado.'));
}
?>
