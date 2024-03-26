<?php
include("../conexion.php");

// Verificar si el formulario ya ha sido enviado
session_start();
if (isset($_SESSION['formulario_enviado']) && $_SESSION['formulario_enviado'] === true) {
    echo '<script>alert("El formulario ya ha sido enviado."); window.location.href = "registro_cliente_form.php";</script>';
    exit;
}

// Recibir datos del formulario y convertir texto a mayúsculas
$tipoID = $_POST['tipoID'];
$numID = $_POST['numID'];
$nombresCL = strtoupper($_POST['nombresCL']);
$sexo = $_POST['sexo'];
$lugar = strtoupper($_POST['lugar']);
$telefono1 = $_POST['telefono1'];
$telefono2 = $_POST['telefono2'];
$direccion = strtoupper($_POST['direccion']);
$email = $_POST['email'];
$fec_nac = $_POST['fec_nac'];
$oficio = strtoupper($_POST['oficio']);
$empresa = strtoupper($_POST['empresa']);

// Preparar la consulta SQL con parámetros
$sql = "INSERT INTO clientes (tipoID, numID, nombresCL, sexo, lugar, telefono1, telefono2, direccion, email, fec_nac, oficio, empresa)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Preparar la declaración
$stmt = $conn->prepare($sql);

// Vincular parámetros
$stmt->bind_param("sissisississ", $tipoID, $numID, $nombresCL, $sexo, $lugar, $telefono1, $telefono2, $direccion, $email, $fec_nac, $oficio, $empresa);

// Ejecutar la consulta
if ($stmt->execute()) {
    echo '<script>alert("Registro exitoso."); window.location.href = "registro_cliente_form.php";</script>';
    
    // Marcar el formulario como enviado
    $_SESSION['formulario_enviado'] = true;
} else {
    echo "Error: " . $stmt->error;
}

// Cerrar declaración y conexión
$stmt->close();
$conn->close();
?>
