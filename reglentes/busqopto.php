<?php
include("../conexion.php");

// Consulta para obtener los datos de la tabla opciones
$sql = "SELECT nombres FROM optometras";
$resultado = $conn->query($sql);

// Generar las opciones del select
$options = '';
if ($resultado->num_rows > 0) {
    while($row = $resultado->fetch_assoc()) {
        $options .= '<option value="' . $row["nombres"] . '">' . $row["nombres"] . '</option>';
    }
}

// Cerrar la conexión
$conn->close();
?>

