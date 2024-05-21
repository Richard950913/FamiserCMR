function limpiarCampos() {
    document.getElementById("registro-form").reset();
    mostrarCamposAdicionales(); // Restablecer la visibilidad de los campos según el tipo de plan
}

$(document).ready(function () {
    // Ocultar campos al cargar la página
    $('#cupolentes-container').hide();
    $('#cupoplan-container').hide();

    // Mostrar/Ocultar campos según selección de producto
    $('#producto').change(function () {
        if ($(this).val() == 'LENTES') {
            $('#cupolentes-container').show();
            $('#cupoplan-container').hide();
        } else if ($(this).val() == 'CREDENCIAL') {
            $('#cupolentes-container').hide();
            $('#cupoplan-container').show();
        }
    });

    // Realizar la búsqueda en tiempo real al escribir en cupolentes
    $('#cupolentes').on('input', function () {
        let cupolentes = $(this).val();
        if (cupolentes.length > 0) {
            $.ajax({
                url: 'verificar_cupo.php',
                type: 'POST',
                data: { tipo: 'LENTES', cupo: cupolentes },
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.exists) {
                        $('#cupolentes-status').html('<i class="fa fa-check" style="color: green;"></i>');
                    } else {
                        $('#cupolentes-status').html('<i class="fa fa-times" style="color: red;"></i>');
                    }
                }
            });
        } else {
            $('#cupolentes-status').html('');
        }
    });

    // Realizar la búsqueda en tiempo real al escribir en cupoplan
    $('#cupoplan').on('input', function () {
        let cupoplan = $(this).val();
        if (cupoplan.length > 0) {
            $.ajax({
                url: 'verificar_cupo.php',
                type: 'POST',
                data: { tipo: 'CREDENCIAL', cupo: cupoplan },
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.exists) {
                        $('#cupoplan-status').html('<i class="fa fa-check" style="color: green;"></i>');
                    } else {
                        $('#cupoplan-status').html('<i class="fa fa-times" style="color: red;"></i>');
                    }
                }
            });
        } else {
            $('#cupoplan-status').html('');
        }
    });

    // Función para limpiar campos
    window.limpiarCampos = function () {
        $('#registro-form')[0].reset();
        $('#cupolentes-status').html('');
        $('#cupoplan-status').html('');
        $('#cupolentes-container').hide();
        $('#cupoplan-container').hide();
    };
});


// Evento para enviar el formulario y registrar los abonos
document.getElementById('registro-form').addEventListener('submit', function (event) {
    event.preventDefault(); // Evitar el envío del formulario por defecto

    // Verificar el estado de cupolentes-status y cupoplan-status
    var cupolentesStatus = document.getElementById('cupolentes-status').innerHTML;
    var cupoplanStatus = document.getElementById('cupoplan-status').innerHTML;

    if ((cupolentesStatus === '' || cupolentesStatus.includes('fa-check')) &&
        (cupoplanStatus === '' || cupoplanStatus.includes('fa-check'))) {
        // Si ambos campos son válidos, proceder con el registro vía Ajax
        var formData = new FormData(this);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'registro_abonos.php', true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                handleRegistroResponse(xhr.responseText); // Manejar la respuesta del servidor
            }
        };
        xhr.send(formData);
    } else {
        // Mostrar mensaje de error si algún campo no es válido
        document.getElementById('mensaje-container').innerHTML = '<p style="color:red;">Verifique que todos los campos sean válidos.</p>';
    }
});

// Función para manejar la respuesta del servidor
function handleRegistroResponse(response) {
    try {
        var jsonResponse = JSON.parse(response);
        if (jsonResponse.success) {
            document.getElementById('mensaje-container').innerHTML = '<p style="color:green;">Registro realizado exitosamente.</p>';
            limpiarCampos(); // Limpiar los campos del formulario
        } else {
            document.getElementById('mensaje-container').innerHTML = '<p style="color:red;">Error al registrar: ' + jsonResponse.message + '</p>';
        }
    } catch (e) {
        document.getElementById('mensaje-container').innerHTML = '<p style="color:red;">Error al procesar la respuesta del servidor.</p>';
    }
}
