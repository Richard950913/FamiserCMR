$(document).ready(function() {
    // Realizar la búsqueda en tiempo real al escribir en id_persona
    $('#id_persona').on('input', function () {
        let id_persona = $(this).val();
        if (id_persona.length > 0) {
            $.ajax({
                url: 'verificar_cliente.php',
                type: 'POST',
                data: { id_persona: id_persona },
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.exists) {
                        $('#cliente-status').html('<i class="fa fa-check" style="color: green;"></i>');
                    } else {
                        $('#cliente-status').html('<i class="fa fa-times" style="color: red;"></i>');
                    }
                }
            });
        } else {
            $('#cliente-status').html('');
        }
    });

    // Manejar el envío del formulario
    $('#registro-form').on('submit', function(e) {
        let clienteStatus = $('#cliente-status').html();
        if (clienteStatus === '' || clienteStatus.includes('fa-times')) {
            e.preventDefault();
            $('#mensaje-container').html('<p style="color: red;">El Id del cliente proporcionado no existe</p>');
        }
    });
});

function limpiarCampos() {
    document.getElementById("registro-form").reset();
    $('#cliente-status').html('');
    $('#mensaje-container').html('');
}
