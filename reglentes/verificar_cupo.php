<?php
include("../conexion.php");

// Obtener el número de cupo de la solicitud AJAX
$cupo = isset($_GET['cupo']) ? $_GET['cupo'] : '';

// Preparar la consulta SQL con una sentencia preparada
$sql = "SELECT COUNT(*) AS existe FROM compra_lentes WHERE cupolente = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cupo); // "i" indica que es un parámetro entero
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    $existe = $fila['existe'];
    echo json_encode(['disponible' => ($existe == 0)]); // Si existe es igual a cero, significa que el cupo está disponible
} else {
    echo json_encode(['disponible' => true]); // Si no hay resultados, el cupo está disponible
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
