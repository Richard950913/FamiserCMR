

//SCRIPT PARA TRAER LOS NOMBRES DE OPTOMETRAS
window.addEventListener('DOMContentLoaded', function () {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'busqopto.php', true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            var select = document.getElementById('optometra');
            select.innerHTML = xhr.responseText;
        }
    };
    xhr.send();
});

//VERIFICA QUE EXISTA EL CLIENTE
var idClienteInput = document.getElementById('idcliente');
var iconoValidacion = document.getElementById('icono-validacion');

idClienteInput.addEventListener('input', function () {
    var idCliente = idClienteInput.value;

    // Verificar si el valor del campo no está vacío
    if (idCliente.trim() !== '') {
        // Realizar la solicitud AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'verificar_cliente.php?id=' + idCliente, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                var respuesta = JSON.parse(xhr.responseText);
                console.log(respuesta); // Imprime la respuesta en la consola
                // Actualizar el icono de validación
                if (respuesta.existe) {
                    iconoValidacion.innerHTML = '<i class="fas fa-check-circle" style="color:green;"></i>';
                } else {
                    iconoValidacion.innerHTML = '<i class="fas fa-times-circle" style="color:red;"></i>';
                }
            }
        };
        xhr.send();
    } else {
        // Si el campo está vacío, elimina el icono de validación
        iconoValidacion.innerHTML = '';
    }
});

//VERIFIICAR QUE EL CUPO EXISTA
var cupoInput = document.getElementById('cupolente');
var cupoValidacion = document.getElementById('cupo-validacion');

cupoInput.addEventListener('input', function () {
    var cupo = cupoInput.value;

    // Verificar si el valor del campo no está vacío
    if (cupo.trim() !== '') {
        // Realizar la solicitud AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'verificar_cupo.php?cupo=' + cupo, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                var respuesta = JSON.parse(xhr.responseText);
                console.log(respuesta); // Imprime la respuesta en la consola
                // Actualizar el mensaje de validación
                if (respuesta.disponible) {
                    cupoValidacion.textContent = 'Cupo disponible';
                    cupoValidacion.style.color = 'green';
                } else {
                    cupoValidacion.textContent = 'Cupo ocupado';
                    cupoValidacion.style.color = 'red';
                }
            }
        };
        xhr.send();
    } else {
        // Si el campo está vacío, elimina el mensaje de validación
        cupoValidacion.textContent = '';
    }
});

// Función para limpiar los campos del formulario
function limpiarCampos() {
    document.getElementById("registro-form").reset();
}

// Función para manejar la respuesta del servidor después de registrar los lentes
function handleRegistroResponse(xhr) {
    if (xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
        var mensajeContainer = document.getElementById('mensaje-container');
        if (response.success) {
            mensajeContainer.innerHTML = 'Compra de lentes registrada correctamente.';
            mensajeContainer.className = 'mensaje-exito';
            limpiarCampos(); // Llamar a la función para limpiar los campos
            // Desaparecer el mensaje después de 5 segundos
            setTimeout(function () {
                mensajeContainer.innerHTML = '';
            }, 3000);
        } else {
            if (response.message.includes('Duplicate entry')) {
                mensajeContainer.innerHTML = 'Error: Ya existe un registro con ese número de cupo.';
            } else {
                mensajeContainer.innerHTML = 'Error: ' + response.message;
            }
            mensajeContainer.className = 'mensaje-error';
        }
    } else {
        console.error('Error en la solicitud AJAX: ' + xhr.status);
    }
}

// Función para mostrar un mensaje flotante
function mostrarMensaje(mensaje) {
    var mensajeFlotante = document.createElement('div');
    mensajeFlotante.className = 'mensaje-flotante';
    mensajeFlotante.textContent = mensaje;

    // Agregar el mensaje justo debajo del campo de ID cliente
    var idClienteInput = document.getElementById('idcliente');
    idClienteInput.parentNode.insertBefore(mensajeFlotante, idClienteInput.nextSibling);

    // Después de 3 segundos, eliminar el mensaje flotante
    setTimeout(function () {
        mensajeFlotante.parentNode.removeChild(mensajeFlotante);
    }, 3000);
}

// Evento para enviar el formulario y registrar los lentes
document.getElementById('registro-form').addEventListener('submit', function (event) {
    event.preventDefault(); // Evitar el envío del formulario por defecto

    // Obtener el indicador de validación del ID cliente
    var iconoValidacion = document.getElementById('icono-validacion');

    // Verificar si el indicador está en rojo (cliente no existente)
    if (iconoValidacion.innerHTML === '<i class="fas fa-times-circle" style="color:red;"></i>') {
        mostrarMensaje('El ID proporcionado no es un cliente existente.');
    } else {
        // Si el indicador está en verde (cliente existente), enviar el formulario normalmente
        var formData = new FormData(this);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'registrar_lentes.php', true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                handleRegistroResponse(xhr); // Manejar la respuesta del servidor
            }
        };
        xhr.send(formData);
    }
});