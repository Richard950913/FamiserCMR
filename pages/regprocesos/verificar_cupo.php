<?php
include("../../conn/conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $cupo = $_POST['cupo_id'];

    $query = $conn->prepare("SELECT COUNT(*) FROM compra_lentes WHERE cupolente = ?");
    $query->bind_param('i', $cupo);
    
    $query->execute();
    $query->bind_result($count);
    $query->fetch();

    echo json_encode(['exists' => $count > 0]);

    $query->close();
}
?>
