<?php
include("../conexion.php");

if (isset($_POST['id']) && !empty($_POST['id'])) {
    $cliente_id = $_POST['id'];

    // Realizar la eliminación del cliente en la base de datos
    $sql = "DELETE FROM clientes WHERE idclientes = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cliente_id);

    if ($stmt->execute()) {
        echo json_encode(array('success' => true));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Error al eliminar el cliente.'));
    }

    $stmt->close();
} else {
    echo json_encode(array('success' => false, 'message' => 'ID de cliente no proporcionado.'));
}
?>
