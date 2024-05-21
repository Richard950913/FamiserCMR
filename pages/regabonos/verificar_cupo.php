<?php
include("../../conn/conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tipo = $_POST['tipo'];
    $cupo = $_POST['cupo'];

    if ($tipo == 'LENTES') {
        $query = $conn->prepare("SELECT COUNT(*) FROM compra_lentes WHERE cupolente = ?");
        $query->bind_param('i', $cupo);
    } else if ($tipo == 'CREDENCIAL') {
        $query = $conn->prepare("SELECT COUNT(*) FROM compra_plan WHERE cupoplan = ?");
        $query->bind_param('i', $cupo);
    }

    $query->execute();
    $query->bind_result($count);
    $query->fetch();

    echo json_encode(['exists' => $count > 0]);

    $query->close();
}
?>
