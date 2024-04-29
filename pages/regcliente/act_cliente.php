<?php
include("../../conn/conexion.php");
include("../../conn/sesion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $cliente_id = $_POST['id'];
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
    
    // Obtener el nombre de usuario actual
    $usuario = $username;

    // Preparar la consulta SQL para obtener los datos del cliente antes de la actualización
    $sql_select_cliente = "SELECT * FROM clientes WHERE idclientes = '$cliente_id'";
    $result = $conn->query($sql_select_cliente);
    $cliente_antiguo = $result->fetch_assoc();

    // Actualizar el registro en la base de datos
    $sql = "UPDATE clientes SET 
                tipoID = '$tipoID', 
                numID = '$numID', 
                nombresCL = '$nombresCL', 
                sexo = '$sexo', 
                lugar = '$lugar', 
                telefono1 = '$telefono1', 
                telefono2 = '$telefono2', 
                direccion = '$direccion', 
                email = '$email', 
                fec_nac = '$fec_nac', 
                oficio = '$oficio', 
                empresa = '$empresa', 
                acudiente = '$acudiente' 
            WHERE idclientes = '$cliente_id'";

    if ($conn->query($sql) === TRUE) {
        // Registro actualizado correctamente, ahora registrar en la tabla de auditoría
        $accion = "modificación";
        $tabla_afectada = "clientes";
        $detalle_cambio = "Cliente actualizado: " . $cliente_antiguo['nombresCL'] . " (" . $cliente_antiguo['numID'] . ")";

        // Preparar la consulta SQL para insertar el registro de auditoría
        $sql_insert_auditoria = "INSERT INTO auditoria_registros (tabla_afectada, accion, usuario, detalle_cambio) VALUES (?, ?, ?, ?)";

        // Preparar la declaración para insertar el registro de auditoría
        $stmt_insert_auditoria = $conn->prepare($sql_insert_auditoria);

        // Vincular parámetros para insertar el registro de auditoría
        $stmt_insert_auditoria->bind_param("ssss", $tabla_afectada, $accion, $usuario, $detalle_cambio);

        // Ejecutar la consulta para insertar el registro de auditoría
        $stmt_insert_auditoria->execute();

        // Cerrar la declaración para insertar el registro de auditoría
        $stmt_insert_auditoria->close();

        echo "Registro actualizado correctamente.<br>";
        echo '<button onclick="cerrarVentana()">Cerrar</button>';
    } else {
        // Error al actualizar el registro
        echo "Error al actualizar el registro: " . $conn->error;
    }

    // Cerrar el resultado de la consulta
    $result->close();
}

// Cerrar conexión
$conn->close();
?>

<script>
    function cerrarVentana() {
        window.location.href = "registro_cliente_form.php";
    }
</script>
