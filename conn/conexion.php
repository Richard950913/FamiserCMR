<?php
// Configuración de la base de datos
$servername = "localhost";
$username_db = "root";
$password_db = "Admin.@1309";
$dbname = "famiser";

// Crear conexión
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error en la conexión a la base de datos: " . $conn->connect_error);
}
?>
