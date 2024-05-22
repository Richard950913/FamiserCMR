<?php
include("../../conn/conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $id_titular = $_POST['id_persona'];

    $query = $conn->prepare("SELECT COUNT(*) FROM clientes WHERE numID = ?");
    $query->bind_param('i', $id_titular);
    
    $query->execute();
    $query->bind_result($count);
    $query->fetch();

    echo json_encode(['exists' => $count > 0]);

    $query->close();
}
?>