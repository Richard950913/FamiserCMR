// SCRIPTS de Registro_cliente_form.php
//Busqueda cliente x AJAX

getData(); // Llamada inicial para cargar los datos al cargar la página
document.getElementById("busqueda").addEventListener("keyup", getData);

function getData() {
    let input = document.getElementById("busqueda").value;
    let content = document.getElementById("content");
    let url = "loadcl.php";
    let formData = new FormData();
    formData.append('busqueda', input);

    fetch(url, {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.html) {
                content.innerHTML = data.html; // Actualiza el contenido de la tabla con el HTML recibido
            } else {
                console.log("No se recibió HTML en la respuesta JSON.");
            }
        })
        .catch(err => console.log(err));
}

// Función para validar el correo electrónico
function validarEmail() {
    var emailInput = document.getElementById("email").value.trim(); // Eliminar espacios en blanco al principio y al final
    // Si el campo está en blanco, permitir que se envíe el formulario
    if (emailInput === "") {
        return true;
    }
    // Si el campo no está en blanco, validar el formato del correo electrónico
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(emailInput)) {
        alert("El email proporcionado no sigue un formato regular.");
        return false; // Evitar que se envíe el formulario
    }
    return true; // Permitir el envío del formulario
}


// Asociar la función de búsqueda al evento de pulsación de tecla
document.getElementById("busqueda").addEventListener("keyup", buscarCliente);



// Funcion de Ajax para verificar el cliente existente automaticamente
function verificarClienteExistente() {
    var numID = document.getElementById("numID").value.trim();

    if (numID === "") {
        document.getElementById("clienteExistenteMsg").innerText = "";
        document.getElementById("clienteExistenteIcon").style.display = "none";
        return;
    }

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            var response = this.responseText;
            if (response === "existe") {
                document.getElementById("clienteExistenteMsg").innerText = "Cliente ya existente";
                document.getElementById("clienteExistenteMsg").style.color = "red";
                document.getElementById("clienteExistenteIcon").style.display = "none";
            } else {
                document.getElementById("clienteExistenteMsg").innerText = "";
                document.getElementById("clienteExistenteIcon").style.display = "inline";
            }
        }
    };
    // Especifica la ruta al archivo verificar_cliente.php
    xhttp.open("POST", "verificar_cliente.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("numID=" + numID);
}

document.getElementById("numID").addEventListener("input", verificarClienteExistente);


//Script de jQuery para enviar los datos del formulario mediante AJAX

$(document).ready(function () {
    $('#registro-form').submit(function (event) {
        event.preventDefault(); // Evitar el envío del formulario por defecto

        $.ajax({
            type: 'POST',
            url: 'registrar_cliente.php', // Ruta al archivo PHP que maneja el registro
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                // Mostrar mensaje de éxito o error
                var messageContainer = $('#mensaje-container');
                if (response.success) {
                    messageContainer.text(response.message).css('color', 'green');
                } else {
                    messageContainer.text(response.message).css('color', 'red');
                }
            },
            error: function () {
                $('#mensaje-container').text('Error al procesar la solicitud.').css('color', 'red');
            }
        });
    });
});
