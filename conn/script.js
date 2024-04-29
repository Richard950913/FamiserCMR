//SCRIPTS de Dashboard.php

function login(event) {
    event.preventDefault(); // Evitar la acción por defecto del formulario (enviar)

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
        // Manejar errores de red o del servidor
        console.error('There has been a problem with your fetch operation:', error);
        document.getElementById('error-msg').innerHTML = 'Ha ocurrido un error. Por favor, intenta de nuevo.';
    });
}

// Agregar evento de envío del formulario para activar la función login
document.getElementById("loginForm").addEventListener("submit", login);

