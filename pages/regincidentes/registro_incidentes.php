<?php
include ("../../conn/conexion.php");
include ("../../conn/sesion.php");
include ("../../conn/validar_rol.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir datos del formulario
    $fec_incid = $_POST['fec_incid'];
    $estado = $_POST['estado'];
    $qn_atend = $_SESSION['username'];
    $id_persona = $_POST['id_persona'];
    $notas = $_POST['notas'];
    $qn_resolv = $_POST['qn_resolv'];
    $solucion = $_POST['solucion'];

    // Verificar que id_persona exista
    $sql_check_persona = "SELECT * FROM clientes WHERE numID = ?";
    $stmt = $conn->prepare($sql_check_persona);
    $stmt->bind_param("i", $id_persona);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Registrar incidente
        $sql_insert_incidente = "INSERT INTO incidentes (fec_incid, estado, qn_atend, id_persona, notas, qn_resolv, solucion) 
                                 VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_insert_incidente);
        $stmt->bind_param("sssisss", $fec_incid, $estado, $qn_atend, $id_persona, $notas, $qn_resolv, $solucion);

        if ($stmt->execute()) {
            // Obtener el id del incidente recién creado
            $id_incidente = $conn->insert_id;

            // Registro de auditoría
            $usuario = $_SESSION['username']; // Suponiendo que el nombre de usuario está en la sesión
            $tabla_afectada = "incidentes"; // Nombre de la tabla afectada
            $accion = "inserción"; // Acción realizada
            $detalle_cambio = "Nuevo incidente registrado: ID Persona $id_persona, Incidente ID $id_incidente";

            // Insertar el registro en la tabla de auditoría
            $sql_auditoria = "INSERT INTO auditoria_registros (tabla_afectada, accion, usuario, detalle_cambio) 
                              VALUES (?, ?, ?, ?)";
            $stmt_auditoria = $conn->prepare($sql_auditoria);
            $stmt_auditoria->bind_param("ssss", $tabla_afectada, $accion, $usuario, $detalle_cambio);
            $stmt_auditoria->execute();

            // Mostrar el registro creado
            echo "<h2>Registro creado exitosamente</h2>";
            echo "<p><strong>Fecha de incidente:</strong> $fec_incid</p>";
            echo "<p><strong>Estado:</strong> $estado</p>";
            echo "<p><strong>Atendido por:</strong> $qn_atend</p>";
            echo "<p><strong>ID Persona:</strong> $id_persona</p>";
            echo "<p><strong>Notas:</strong> $notas</p>";
            echo "<p><strong>Resuelto por:</strong> $qn_resolv</p>";
            echo "<p><strong>Solución:</strong> $solucion</p>";
            echo "<p><strong>El número de radicado es:</strong> $id_persona - $id_incidente</p>";
        } else {
            echo "<p>Error al registrar el incidente.</p>";
        }
    } else {
        echo "<p>El ID de persona no existe.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/styleplan.css">
    <title>Registro de incidentes</title>
</head>

<body>
    
    <div class="button-container">
        <a href="/ini/pages/regincidentes/registro_incidentes_form.php" class="btn-volver">Volver al inicio</a>
    </div>
    <style>
        .btn-volver {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-volver:hover {
            background-color: #0056b3;
        }
    </style>
</body>

</html>
