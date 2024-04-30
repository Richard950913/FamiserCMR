//----------------------INICIO verificar edad si es menor----------------

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
//--------------------------FIN VERIFICAR MENOR DE EDAD---------------------------------------
//------------------------------ELIMINAR CLIENTE----------------------------------------------

function eliminarCliente(id, nombre) {
    var confirmacion = confirm("¿Está seguro de eliminar este registro? " + nombre);

    if (confirmacion) {
        // Enviar la solicitud AJAX para eliminar el cliente
        $.ajax({
            type: 'POST',
            url: 'eliminar_cliente.php',
            data: { id: id },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    // Eliminación exitosa
                    alert("El cliente ha sido eliminado correctamente.");
                    // Aquí puedes recargar la lista de clientes si lo deseas
                } else {
                    // Error al eliminar el cliente
                    alert("Error al eliminar el cliente: " + response.message);
                }
            },
            error: function () {
                // Error de conexión
                alert("Error al procesar la solicitud. Por favor, inténtelo nuevamente.");
            }
        });
    }
}

//------------------------------FIN ELIMINAR CLIENTE----------------------------------------------

//------------------------BUSQUEDA DE CLIENTE X AJAX------------------------------------------
var inicio = 0;
var cantidadRegistros = 10;
var totalRegistros = 0;

// Función de carga inicial de la página
window.onload = function () {
    actualizarBotonesNavegacion();
    actualizarTotalRegistros();
    getData();
};

// Función para actualizar el estado de los botones de navegación
function actualizarBotonesNavegacion() {
    var prevButton = document.getElementById("prevButton");
    var nextButton = document.getElementById("nextButton");

    prevButton.disabled = inicio <= 0;
    nextButton.disabled = inicio + cantidadRegistros >= totalRegistros;
}

// Función para actualizar el elemento que muestra el total de registros
function actualizarTotalRegistros() {
    var totalRegistrosSpan = document.getElementById("totalRegistrosSpan");
    totalRegistrosSpan.innerText = "Hay " + totalRegistros + " registros";
}

// Función para obtener los datos mediante AJAX
function getData() {
    var input = document.getElementById("busqueda").value;
    var content = document.getElementById("content");
    var url = "loadcl.php";
    var formData = new FormData();
    formData.append('busqueda', input);
    formData.append('inicio', inicio);
    formData.append('cantidadRegistros', cantidadRegistros);

    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.html) {
            content.innerHTML = data.html;
            totalRegistros = data.totalRegistros;
            actualizarTotalRegistros();
            actualizarBotonesNavegacion();
        } else {
            console.log("No se recibió HTML en la respuesta JSON.");
        }
    })
    .catch(err => console.log(err));
}

// Escuchar eventos para cambios en la búsqueda y cantidad de registros
document.getElementById("busqueda").addEventListener("keyup", getData);

document.getElementById("cantidadRegistros").addEventListener("change", function () {
    cantidadRegistros = parseInt(this.value);
    inicio = 0; // Reiniciar inicio al cambiar la cantidad de registros
    getData();
});

// Eventos para navegación entre páginas de resultados
document.getElementById("prevButton").addEventListener("click", function () {
    inicio -= cantidadRegistros;
    getData();
});

document.getElementById("nextButton").addEventListener("click", function () {
    inicio += cantidadRegistros;
    getData();
});

//------------------------FIN BUSQUEDA DE CLIENTE X AJAX------------------------------------------

//---------------------------- VALIDAR EL CORREO ELECTRONICO----------------------------
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
window.onload = validarEmail;
//----------------------------FIN VALIDAR EL CORREO ELECTRONICO----------------------------