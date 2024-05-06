document.addEventListener('DOMContentLoaded', function() {
    // Verificar cupo
    var cupoInput = document.getElementById('cupoplan');
    var cupoValidacion = document.getElementById('cupo-validacion');

    cupoInput.addEventListener('input', function() {
        var cupo = cupoInput.value;

        // Verificar si el valor del campo no está vacío
        if (cupo.trim() !== '') {
            // Realizar la solicitud AJAX para verificar el cupo
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'verificar_cupo.php?cupo=' + cupo, true);
            xhr.onload = function() {
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

    // Verificar existencia del cliente
    var idClienteInput = document.getElementById('id_titular');
    var iconoValidacion = document.getElementById('icono-validacion');

    idClienteInput.addEventListener('input', function() {
        var idCliente = idClienteInput.value;

        // Verificar si el valor del campo no está vacío
        if (idCliente.trim() !== '') {
            // Realizar la solicitud AJAX para verificar el cliente
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'verificar_cliente.php?id=' + idCliente, true);
            xhr.onload = function() {
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
});
