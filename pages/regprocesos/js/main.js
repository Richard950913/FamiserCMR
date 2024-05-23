function limpiarCampos() {
    document.getElementById("registro-form").reset();
}

$(document).ready(function() {
    console.log("jQuery is loaded");

    // Realizar la búsqueda en tiempo real al escribir en cupo
    $('#cupo_id').on('input', function () {
        let cupo_id = $(this).val();
        if (cupo_id.length > 0) {
            $.ajax({
                url: 'verificar_cupo.php',
                type: 'POST',
                data: { cupo_id: cupo_id },
                success: function (response) {
                    console.log("Response from verificar_cupo.php:", response);
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

    // Registro de la garantia
    document.getElementById('registro-form').addEventListener('submit', function (event) {
        event.preventDefault(); // Evitar el envío del formulario por defecto

        // Verificar el estado de cupo-status
        var cupoStatus = document.getElementById('cupo-status').innerHTML;

        if (cupoStatus === '' || cupoStatus.includes('fa-check')) {
            // Si el campo es válido, proceder con el registro vía Ajax
            var formData = new FormData(this);
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'registro_proceso.php', true);
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
});