//<!-- Incluir el archivo de scripts -->

    // Función para validar el correo electrónico
    function validarEmail() {
        var emailInput = document.getElementById("email").value.trim(); // Eliminar espacios en blanco al principio y al final
        var emailError = document.getElementById("emailError");
        // Si el campo no está en blanco y no sigue un formato de correo electrónico válido, mostrar un mensaje de error
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (emailInput !== "" && !emailRegex.test(emailInput)) {
            emailError.innerText = "El email proporcionado no sigue un formato regular.";
            return false; // Evitar que se envíe el formulario
        } else {
            emailError.innerText = ""; // Limpiar el mensaje de error si el correo es válido
            return true; // Permitir el envío del formulario
        }
    }

    // Asignar la función validarEmail() al evento de envío del formulario
    document.getElementById("editarForm").addEventListener("submit", function (event) {
        if (!validarEmail()) {
            event.preventDefault(); // Detener el envío del formulario si el correo no cumple el formato
        }
    });

//<!-- verificar edad si es menor-->

    // Función para actualizar la visibilidad del campo de acudiente según la edad
    function actualizarCampos() {
        var fechaNacimiento = document.getElementById("fec_nac").value;
        var hoy = new Date();
        var fechaNacimiento = new Date(fechaNacimiento);
        var edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
        var mes = hoy.getMonth() - fechaNacimiento.getMonth();

        if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
            edad--;
        }

        var acudienteContainer = document.getElementById("acudienteContainer");

        if (edad < 18) {
            acudienteContainer.style.display = "block";
            document.getElementById("acudiente").required = true;
        } else {
            acudienteContainer.style.display = "none";
            document.getElementById("acudiente").required = false;
            document.getElementById("acudiente").value = ""; // Limpiar el valor si se oculta
        }
    }

    // Asignar la función actualizarCampos al evento onchange del campo de fecha de nacimiento
    document.getElementById("fec_nac").addEventListener("change", actualizarCampos);

    // Llamar a la función actualizarCampos al cargar la página para asegurarse de que el campo se oculte inicialmente
    window.onload = actualizarCampos;
