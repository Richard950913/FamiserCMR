<?php
include("../conexion.php");

// Recibir datos del formulario y convertir texto a mayúsculas
$tipoID = $_POST['tipoID'];
$numID = $_POST['numID'];
$nombresCL = strtoupper($_POST['nombresCL']);
$sexo = $_POST['sexo'];
$lugar = strtoupper($_POST['lugar']); 
$telefono1 = $_POST['telefono1'] !== '' ? $_POST['telefono1'] : null;
$telefono2 = $_POST['telefono2'] !== '' ? $_POST['telefono2'] : null;
$direccion = strtoupper($_POST['direccion']);
$email = $_POST['email'] !== '' ? $_POST['email'] : null;
$fec_nac = $_POST['fec_nac'] !== '' ? $_POST['fec_nac'] : null;
$oficio = strtoupper($_POST['oficio']) !== '' ? $_POST['oficio'] : null;
$empresa = strtoupper($_POST['empresa'])!== '' ? $_POST['empresa'] : null;

try {
    // Preparar la consulta SQL con parámetros
    $sql = "INSERT INTO clientes (tipoID, numID, nombresCL, sexo, lugar, telefono1, telefono2, direccion, email, fec_nac, oficio, empresa)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Preparar la declaración
    $stmt = $conn->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param("sisssiississ", $tipoID, $numID, $nombresCL, $sexo, $lugar, $telefono1, $telefono2, $direccion, $email, $fec_nac, $oficio, $empresa);

    // Ejecutar la consulta
    $stmt->execute();

    echo '<script>alert("Registro exitoso."); window.location.href = "registro_cliente_form.php";</script>';
    

} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1062) {
        echo '<script>alert("El cliente con el número de identificación ' . $numID . ' ya existe."); window.location.href = "registro_cliente_form.php";</script>';
    } else {
        echo '<script>alert("Error al registrar el cliente. Por favor, intente nuevamente más tarde."); window.location.href = "registro_cliente_form.php";</script>';
    }
}

// Cerrar declaración y conexión
$stmt->close();
?>
