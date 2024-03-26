function login() {
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;

    // Realizar la solicitud al servidor usando fetch
    fetch('login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'username=' + encodeURIComponent(username) + '&password=' + encodeURIComponent(password),
    })
    .then(response => {
        if (response.ok) {
            return response.text();
        }
        throw new Error('Network response was not ok.');
    })
    .then(data => {
        if (data === 'success') {
            // Si el inicio de sesión es exitoso, redirigir al usuario al dashboard
            window.location.href = 'dashboard.php';
        } else {
            // Si hay un error en el inicio de sesión, mostrar un mensaje de error
            document.getElementById('error-msg').innerHTML = 'Credenciales incorrectas. Por favor, intenta de nuevo.';
        }
    })
    .catch(error => {
        console.error('There has been a problem with your fetch operation:', error);
    });
}

// Agregar evento de teclado para activar la función login al presionar Enter
document.getElementById("loginForm").addEventListener("keypress", function(event) {
    // Verificar si la tecla presionada es Enter
    if (event.keyCode === 13) {
        event.preventDefault(); // Evitar la acción por defecto del formulario (enviar)
        login(); // Llamar a la función de inicio de sesión
    }
});
