<?php
include("../../conn/conexion.php");
include("../../conn/sesion.php");

// Inicializar la respuesta predeterminada
$response = array(
    'success' => false,
    'message' => 'Error al procesar la solicitud.'
);

try {
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
    $oficio = strtoupper($_POST['oficio']);
    $empresa = strtoupper($_POST['empresa']);
    $acudiente = strtoupper($_POST['acudiente']);

    // Guardar el nombre de usuario actual
    $usuario = $username;

    // Preparar la consulta SQL con parámetros para insertar el cliente
    $sql_insert_cliente = "INSERT INTO clientes (tipoID, numID, nombresCL, sexo, lugar, telefono1, telefono2, direccion, email, fec_nac, oficio, empresa, acudiente)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Preparar la declaración para insertar el cliente
    $stmt_insert_cliente = $conn->prepare($sql_insert_cliente);

    // Vincular parámetros para insertar el cliente
    $stmt_insert_cliente->bind_param("sisssiissssss", $tipoID, $numID, $nombresCL, $sexo, $lugar, $telefono1, $telefono2, $direccion, $email, $fec_nac, $oficio, $empresa, $acudiente);

    // Ejecutar la consulta para insertar el cliente
    if ($stmt_insert_cliente->execute()) {
        // Registro exitoso del cliente, ahora registrar en la tabla de auditoría
        $accion = "inserción";
        $tabla_afectada = "clientes";
        $detalle_cambio = "Nuevo cliente agregado: " . $nombresCL . " (" . $numID . ")";

        // Preparar la consulta SQL para insertar el registro de auditoría
        $sql_insert_auditoria = "INSERT INTO auditoria_registros (tabla_afectada, accion, usuario, detalle_cambio) VALUES (?, ?, ?, ?)";

        // Preparar la declaración para insertar el registro de auditoría
        $stmt_insert_auditoria = $conn->prepare($sql_insert_auditoria);

        // Vincular parámetros para insertar el registro de auditoría
        $stmt_insert_auditoria->bind_param("ssss", $tabla_afectada, $accion, $usuario, $detalle_cambio);

        // Ejecutar la consulta para insertar el registro de auditoría
        $stmt_insert_auditoria->execute();

        // Establecer la respuesta de éxito
        $response['success'] = true;
        $response['message'] = 'Registro exitoso.';
    } else {
        // Error al registrar el cliente
        $response['message'] = 'Error al registrar el cliente. Por favor, intente nuevamente más tarde.';
    }

} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1062) {
        // Cliente con el número de identificación ya existe
        $response['message'] = "El cliente con el número de identificación '$numID' ya existe.";
    }
}

// Devolver la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);

// Cerrar declaraciones y conexión
$stmt_insert_cliente->close();
$stmt_insert_auditoria->close();
$conn->close();
?>
