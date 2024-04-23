<?php
include("../conexion.php");

// Obtener el ID del cliente de la solicitud AJAX
$idCliente = isset($_GET['id']) ? $_GET['id'] : '';

// Preparar la consulta SQL con una sentencia preparada
$sql = "SELECT COUNT(*) AS existe FROM clientes WHERE numID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idCliente); // "i" indica que es un parámetro entero
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    $existe = $fila['existe'];
    echo json_encode(['existe' => ($existe > 0)]);
} else {
    echo json_encode(['existe' => false]);
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
