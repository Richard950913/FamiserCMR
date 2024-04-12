<?php
include ("../conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $cliente_id = $_POST['id'];
    $tipoID = $_POST['tipoID'];
    $numID = $_POST['numID'];
    $nombresCL = $_POST['nombresCL'];
    $sexo = $_POST['sexo'];
    $lugar = $_POST['lugar'];
    $telefono1 = $_POST['telefono1'];
    $telefono2 = $_POST['telefono2'];
    $direccion = $_POST['direccion'];
    $email = $_POST['email'];
    $fec_nac = $_POST['fec_nac'];
    $oficio = $_POST['oficio'];
    $empresa = $_POST['empresa'];

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
                empresa = '$empresa' 
            WHERE idclientes = '$cliente_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Registro actualizado correctamente.<br>";
        echo '<button onclick="cerrarVentana()">Cerrar</button>';
    } else {
        echo "Error al actualizar el registro: " . $conn->error;
    }
}

$conn->close();

?>

<script>
    function cerrarVentana() {
        window.location.href = "registro_cliente_form.php";
    }
</script>