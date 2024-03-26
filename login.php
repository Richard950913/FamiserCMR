<?php
// Incluir el archivo de conexión
include 'conexion.php';

//Recibir datos del formulario
$username = $_POST['username'];
$password = $_POST['password'];

// Consulta SQL para verificar las credenciales
$sql = "SELECT * FROM usuario WHERE username = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Inicio de sesión exitoso
    session_start();
    $_SESSION['username'] = $username;
    echo "success";

    $username = $_SESSION['username'];
} else {
    // Credenciales incorrectas
    echo "error";
}

