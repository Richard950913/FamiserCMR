<?php
require "../../conn/conexion.php";

$columns = ["cupoplan", "estado", "fecha_vinc", "tipo_plan", "id_titular", "valor_total", "forma_pago"];
$table = "compra_plan";

// Validar y obtener el campo de búsqueda
$campo = isset($_POST["busqueda"]) ? $conn->real_escape_string($_POST["busqueda"]) : null;

// Construir la cláusula WHERE dinámicamente
$where = "";
if ($campo != null) {
    $where = " WHERE (";
    $cont = count($columns);

    for ($i = 0; $i < $cont; $i++) {
        $where .= $columns[$i] . " LIKE '%" . $campo . "%' OR ";
    }
    $where = rtrim($where, " OR ") . ")";
}

// Obtener la cantidad total de registros
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
        foreach ($columns as $column) {
            if ($column == 'id_titular') {
                // Añadir un evento onclick para redirigir usando JavaScript
                $html .= '<td><a href= "#" onclick="redirectToEditClientMain(\'' . htmlspecialchars($row[$column]) . '\')">' . htmlspecialchars($row[$column]) . '</a></td>';
            } else {
                $html .= '<td>' . htmlspecialchars($row[$column]) . '</td>';
            }
        }
        $html .= '<td><a href="vis_plan.php?id=' . $row['cupoplan'] . '">Visualizar</a></td>';
        $html .= '<td><a href="#" onclick="eliminarPlan(' . $row['cupoplan'] . ', \'' . addslashes($row['cupoplan']) . '\')">Eliminar</a></td>';
        $html .= '</tr>';
    }
} else {
    $html .= '<tr>';
    $html .= '<td colspan="' . count($columns) . '">Sin resultados</td>';
    $html .= '</tr>';
}

// Devolver el HTML y la cantidad total de registros en un objeto JSON
echo json_encode(array('html' => $html, 'totalRegistros' => $totalRegistros), JSON_UNESCAPED_UNICODE);
?>
