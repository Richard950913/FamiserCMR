<?php
include("../../conn/conexion.php");

// Obtener el ID del cliente de la solicitud AJAX y asegurar que sea un entero válido
$idCliente = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Preparar la consulta SQL utilizando una sentencia preparada
$sql = "SELECT COUNT(*) AS existe FROM clientes WHERE numID = ?";
$stmt = $conn->prepare($sql);

// Vincular el parámetro de la sentencia preparada
$stmt->bind_param("i", $idCliente); // "i" indica que se espera un parámetro entero

// Ejecutar la consulta preparada
$stmt->execute();

// Obtener el resultado de la consulta
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    $existe = $fila['existe'];
    echo json_encode(['existe' => ($existe > 0)]);
} else {
    echo json_encode(['existe' => false]);
}

// Cerrar el statement y la conexión
$stmt->close();
$conn->close();
?>
