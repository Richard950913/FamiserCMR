<?php
include("../conexion.php");

if (isset($_POST['numID'])) {
    $numID = $_POST['numID'];

    // Preparar la consulta SQL
    $sql = "SELECT * FROM clientes WHERE numID = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $numID);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si el número de identificación existe
    if ($result->num_rows > 0) {
        echo "existe";
    } else {
        echo "no_existe";
    }
}
?>
