<?php
require "../../conn/conexion.php";

$columns = ["cupoplan", "estado", "fecha_vinc", "tipo_plan", "id_titular", "valor_total", "forma_pago"];
$table = "compra_plan";

$campo = isset($_POST["busqueda"]) ? $conn->real_escape_string($_POST["busqueda"]) : null;

$where = "";
if ($campo != null) {
    $where = " WHERE (";
    $cont = count($columns);

    for ($i = 0; $i < $cont; $i++) {
        $where .= $columns[$i] . " LIKE '%" . $campo . "%' OR ";
    }
    $where = substr_replace($where, "", -3);
    $where .= ")";
}

// Obtener la cantidad de registros totales
$sqlCount = "SELECT COUNT(*) as total FROM $table $where";
$resultCount = $conn->query($sqlCount);
$rowCount = $resultCount->fetch_assoc();
$totalRegistros = $rowCount['total'];

// Obtener el rango de registros a mostrar
$inicio = isset($_POST['inicio']) ? intval($_POST['inicio']) : 0;
$cantidadRegistros = isset($_POST['cantidadRegistros']) ? intval($_POST['cantidadRegistros']) : 10;

$sql = "SELECT " . implode(", ", $columns) . " FROM $table $where LIMIT $inicio, $cantidadRegistros";
$resultado = $conn->query($sql);
$num_rows = $resultado->num_rows;

$html = "";
if ($num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $html .= '<tr>';
        $html .= '<td>' . $row['cupoplan'] . '</td>';
        $html .= '<td>' . $row['estado'] . '</td>';
        $html .= '<td>' . $row['fecha_vinc'] . '</td>';
        $html .= '<td>' . $row['tipo_plan'] . '</td>';
        $html .= '<td>' . $row['id_titular'] . '</td>';
        $html .= '<td>' . $row['valor_total'] . '</td>';
        $html .= '<td>' . $row['forma_pago'] . '</td>';
        $html .= '<td><a href="editar_plan.php?id=' . $row['idclientes'] . '">Editar</a></td>';
        $html .= '<td><a href="#" onclick="eliminarPlan(' . $row['idclientes'] . ', \'' . addslashes($row['nombresCL']) . '\')">Eliminar</a></td>';
        $html .= '</tr>';
    }
} else {
    $html .= '<tr>';
    $html .= '<td colspan="9">Sin resultados</td>';
    $html .= '</tr>';
}

// Devolver el HTML y la cantidad total de registros en un objeto JSON
echo json_encode(array('html' => $html, 'totalRegistros' => $totalRegistros), JSON_UNESCAPED_UNICODE);
?>
