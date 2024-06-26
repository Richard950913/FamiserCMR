<?php
require "../../conn/conexion.php";

$columns = ["idclientes", "tipoID", "numID", "nombresCL", "sexo", "lugar", "telefono1", "telefono2", "direccion", "email", "fec_nac", "oficio", "empresa", "acudiente"];
$table = "clientes";

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
        $html .= '<td>' . $row['idclientes'] . '</td>';
        $html .= '<td>' . $row['tipoID'] . '</td>';
        $html .= '<td>' . $row['numID'] . '</td>';
        $html .= '<td>' . $row['nombresCL'] . '</td>';
        $html .= '<td>' . $row['sexo'] . '</td>';
        $html .= '<td>' . $row['lugar'] . '</td>';
        $html .= '<td>' . $row['telefono1'] . '</td>';
        $html .= '<td>' . $row['telefono2'] . '</td>';
        $html .= '<td>' . $row['direccion'] . '</td>';
        $html .= '<td>' . $row['email'] . '</td>';
        $html .= '<td>' . $row['fec_nac'] . '</td>';
        $html .= '<td>' . $row['oficio'] . '</td>';
        $html .= '<td>' . $row['empresa'] . '</td>';
        $html .= '<td>' . $row['acudiente'] . '</td>';
        $html .= '<td><a href="editar_cliente.php?id=' . $row['idclientes'] . '">Visualizar</a></td>';
        $html .= '<td><a href="#" onclick="eliminarCliente(' . $row['idclientes'] . ', \'' . addslashes($row['nombresCL']) . '\')">Eliminar</a></td>';
        $html .= '</tr>';
    }
} else {
    $html .= '<tr>';
    $html .= '<td colspan="16">Sin resultados</td>';
    $html .= '</tr>';
}

// Devolver el HTML y la cantidad total de registros en un objeto JSON
echo json_encode(array('html' => $html, 'totalRegistros' => $totalRegistros), JSON_UNESCAPED_UNICODE);
?>
