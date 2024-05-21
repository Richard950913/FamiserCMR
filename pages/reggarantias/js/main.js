function limpiarCampos() {
    document.getElementById("registro-form").reset();
    
}

// Realizar la búsqueda en tiempo real al escribir en cupo
$('#cupo').on('input', function () {
    let cupo = $(this).val();
    if (cupo.length > 0) {
        $.ajax({
            url: 'verificar_cupo.php',
            type: 'POST',
            data: { cupo: cupo },
            success: function (response) {
                response = JSON.parse(response);
                if (response.exists) {
                    $('#cupo-status').html('<i class="fa fa-check" style="color: green;"></i>');
                } else {
                    $('#cupo-status').html('<i class="fa fa-times" style="color: red;"></i>');
                }
            }
        });
    } else {
        $('#cupo-status').html('');
    }
});
//registro de la garantia
document.getElementById('registro-form').addEventListener('submit', function (event) {
    event.preventDefault(); // Evitar el envío del formulario por defecto

    // Verificar el estado de cupolentes-status y cupoplan-status
    var cupolentesStatus = document.getElementById('cupo-status').innerHTML;
    
    if ((cupolentesStatus === '' || cupolentesStatus.includes('fa-check'))) {
        // Si ambos campos son válidos, proceder con el registro vía Ajax
        var formData = new FormData(this);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'registro_garantias.php', true);
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
        console.error("Error al procesar la respuesta del servidor:", e);
        console.error("Respuesta recibida:", response);
        document.getElementById('mensaje-container').innerHTML = '<p style="color:red;">Error al procesar la respuesta del servidor.</p>';
    }
}
