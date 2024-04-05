<?php
require "../conexion.php";

$columns = ["tipoID", "numID", "nombresCL", "sexo", "lugar", "telefono1", "telefono2", "direccion", "email", "fec_nac", "oficio", "empresa"];
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

// Obtener la cantidad total de registros
$sql_total = "SELECT COUNT(*) AS total FROM $table $where";
$resultado_total = $conn->query($sql_total);
$total_registros = $resultado_total->fetch_assoc()['total'];

// Definir la cantidad de registros a mostrar por página
$registros_por_pagina = 10;

// Calcular la cantidad de páginas
$total_paginas = ceil($total_registros / $registros_por_pagina);

// Calcular el número de página actual
$pagina_actual = isset($_POST['pagina']) ? intval($_POST['pagina']) : 1;

// Calcular el inicio del límite para la consulta SQL
$offset = ($pagina_actual - 1) * $registros_por_pagina;

$sql = "SELECT " . implode(", ", $columns) . " FROM $table $where LIMIT $registros_por_pagina OFFSET $offset";

$resultado = $conn->query($sql);
$num_rows = $resultado->num_rows;

$html = "";
if ($num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $html .= '<tr>';
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
        $html .= '<td><a href="">Editar</a></td>';
        $html .= '<td><a href="">Eliminar</a></td>';
        $html .= '</tr>';
    }
} else {
    $html .= '<tr>';
    $html .= '<td colspan="14">Sin resultados</td>';
    $html .= '</tr>';
}

// Devolver el HTML como parte de un objeto JSON
echo json_encode(array('html' => $html, 'total_registros' => $total_registros, 'total_paginas' => $total_paginas), JSON_UNESCAPED_UNICODE);
?>
