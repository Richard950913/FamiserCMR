<?php
// Conexión a la base de datos (incluye el archivo de conexión)
include("../../conn/conexion.php");
include("../../conn/sesion.php");

// Verifica si se está enviando datos por método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibe los datos del formulario y convierte los campos de texto a mayúsculas
    $cupoplan = strtoupper(!empty($_POST['cupoplan']) ? $_POST['cupoplan'] : null);
    $estado = strtoupper(!empty($_POST['estado']) ? $_POST['estado'] : null);
    $fecha_vinc = $_POST['fecha_vinc'];
    $tipo_plan = $_POST['tipo_plan'];
    $id_titular = $_POST['id_titular'];
    $valor_total = $_POST['valor_total'];
    $forma_pago = $_POST['forma_pago'];
    $nombres1 = strtoupper(!empty($_POST['nombres1']) ? $_POST['nombres1'] : null);
    $fec_nac1 = $_POST['fec_nac1'];
    $parent1 = strtoupper(!empty($_POST['parent1']) ? $_POST['parent1'] : null);
    $nombres2 = strtoupper(!empty($_POST['nombres2']) ? $_POST['nombres2'] : null);
    $fec_nac2 = $_POST['fec_nac2'];
    $parent2 = strtoupper(!empty($_POST['parent2']) ? $_POST['parent2'] : null);
    $nombres3 = strtoupper(!empty($_POST['nombres3']) ? $_POST['nombres3'] : null);
    $fec_nac3 = $_POST['fec_nac3'];
    $parent3 = strtoupper(!empty($_POST['parent3']) ? $_POST['parent3'] : null);
    $nombres4 = strtoupper(!empty($_POST['nombres4']) ? $_POST['nombres4'] : null);
    $fec_nac4 = $_POST['fec_nac4'];
    $parent4 = strtoupper(!empty($_POST['parent4']) ? $_POST['parent4'] : null);
    $nombres5 = strtoupper(!empty($_POST['nombres5']) ? $_POST['nombres5'] : null);
    $fec_nac5 = $_POST['fec_nac5'];
    $parent5 = strtoupper(!empty($_POST['parent5']) ? $_POST['parent5'] : null);
    $nombres6 = strtoupper(!empty($_POST['nombres6']) ? $_POST['nombres6'] : null);
    $fec_nac6 = $_POST['fec_nac6'];
    $parent6 = strtoupper(!empty($_POST['parent6']) ? $_POST['parent6'] : null);
    $nombres7 = strtoupper(!empty($_POST['nombres7']) ? $_POST['nombres7'] : null);
    $fec_nac7 = $_POST['fec_nac7'];
    $parent7 = strtoupper(!empty($_POST['parent7']) ? $_POST['parent7'] : null);
    $comentarios = strtoupper(!empty($_POST['comentarios']) ? $_POST['comentarios'] : null);
    $empresa = strtoupper(!empty($_POST['empresa']) ? $_POST['empresa'] : null);

    // Prepara la consulta SQL para compra_plan utilizando prepared statements
    $sql = "INSERT INTO compra_plan (cupoplan, estado, fecha_vinc, tipo_plan, id_titular, valor_total, forma_pago, nombres1, fec_nac1, parent1, nombres2, fec_nac2, parent2, nombres3, fec_nac3, parent3, nombres4, fec_nac4, parent4, nombres5, fec_nac5, parent5, nombres6, fec_nac6, parent6, nombres7, fec_nac7, parent7, comentarios, empresa) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Inicializa una declaración preparada para la inserción en compra_plan
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        // Vincula los parámetros con la declaración preparada como parámetros
        mysqli_stmt_bind_param($stmt, "isssiissssssssssssssssssssssss", 
            $cupoplan, $estado, $fecha_vinc, $tipo_plan, $id_titular, $valor_total, 
            $forma_pago, $nombres1, $fec_nac1, $parent1, $nombres2, $fec_nac2, $parent2, 
            $nombres3, $fec_nac3, $parent3, $nombres4, $fec_nac4, $parent4, 
            $nombres5, $fec_nac5, $parent5, $nombres6, $fec_nac6, $parent6, 
            $nombres7, $fec_nac7, $parent7, $comentarios, $empresa);

        // Ejecuta la declaración preparada para la inserción en compra_plan
        if (mysqli_stmt_execute($stmt)) {
            $response = array(
                'success' => true,
                'message' => '¡Registro del plan realizado con éxito!'
            );

            // Auditoría de registros
            $usuario = $username; // Obtén el nombre de usuario actual
            $tabla_afectada = "compra_plan"; // Nombre de la tabla afectada
            $accion = "inserción"; // Acción realizada
            $detalle_cambio = "Nuevo plan registrado: CupoPlan = $cupoplan, Titular = $id_titular";

            // Prepara la consulta SQL para auditoría utilizando prepared statements
            $audit_sql = "INSERT INTO auditoria_registros (tabla_afectada, accion, usuario, detalle_cambio) 
                          VALUES (?, ?, ?, ?)";
            
            $stmt_audit = mysqli_stmt_init($conn);
            if (mysqli_stmt_prepare($stmt_audit, $audit_sql)) {
                // Vincula los parámetros con la declaración preparada para auditoría
                mysqli_stmt_bind_param($stmt_audit, "ssss", $tabla_afectada, $accion, $usuario, $detalle_cambio);

                // Ejecuta la declaración preparada para auditoría
                mysqli_stmt_execute($stmt_audit);
                mysqli_stmt_close($stmt_audit);
            } else {
                // Manejar errores de preparación de la consulta de auditoría
                error_log("Error al preparar la consulta de auditoría: " . mysqli_error($conn));
            }
        } else {
            $response = array(
                'success' => false,
                'message' => 'Error al registrar el plan. Inténtalo de nuevo.'
            );
        }
        
        // Cierra la declaración preparada para la inserción en compra_plan
        mysqli_stmt_close($stmt);
    } else {
        $response = array(
            'success' => false,
            'message' => 'Error al preparar la consulta para registrar el plan. Inténtalo de nuevo.'
        );
    }

    // Devuelve la respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
