<?php
include("../conexion.php");

if (isset($_POST['numID'])) {
    $numID = $_POST['numID'];

    // Preparar la consulta SQL
    $sql = "SELECT * FROM clientes WHERE numID = ?";
    $stmt = $conn->prepare($sql); // Utiliza $conn en lugar de $mysqli ya que la conexion esta incluida en conexion.php
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

