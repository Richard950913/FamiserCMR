document.addEventListener("DOMContentLoaded", function () {

    //---------- Funcion de Ajax para verificar el cliente existente automaticamente --------------------
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

    //---------- FIN Funcion de Ajax para verificar el cliente existente automaticamente --------------------

    //--------------- Script de jQuery para enviar los datos del formulario mediante AJAX ---------------------
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
    //--------------- Fin Script de jQuery para enviar los datos del formulario mediante AJAX ---------------------

    // Ahora puedes agregar el listener después de que el DOM esté completamente cargado
    document.getElementById("numID").addEventListener("input", verificarClienteExistente);
});
