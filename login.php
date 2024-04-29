<?php
// Incluir el archivo de conexión
include 'conn/conexion.php';

//Recibir datos del formulario
$username = $_POST['username'];
$password = $_POST['password'];

// Consulta SQL para verificar las credenciales y obtener el rol del usuario
$sql = "SELECT rol FROM usuario WHERE username = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Inicio de sesión exitoso
    session_start();
    $_SESSION['username'] = $username;
    
    // Obtener el rol del usuario
    $row = $result->fetch_assoc();
    $rol_ID = $row['rol'];

    // Almacena el rol en la sesión
    $_SESSION['rol_ID'] = $rol_ID;

    echo "success";
} else {
    // Credenciales incorrectas
    echo "error";
}
?>
