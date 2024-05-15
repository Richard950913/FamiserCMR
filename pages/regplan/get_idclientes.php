<?php
include ("../../conn/conexion.php");

if (isset($_POST['numId'])) {
    $numId = $_POST['numId'];
    
    $sql = "SELECT idclientes FROM clientes WHERE numID = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $numId);
        $stmt->execute();
        $stmt->bind_result($idclientes);
        $stmt->fetch();
        $stmt->close();

        echo $idclientes;
    } else {
        echo "Error en la consulta";
    }
    
    $conn->close();
} else {
    echo "No se proporcionó numId";
}
?>
