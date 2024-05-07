function mostrarCamposAdicionales() {
    var tipoPlan = document.getElementById("tipo_plan").value;
    var extraPersonas = document.querySelector(".extra-personas");
    var empresaInput = document.getElementById("empresa");
    var empresaLabel = document.getElementById("empresaLabel");
    var valorTotalInput = document.getElementById("valor_total");

    if (tipoPlan === "2") {
        extraPersonas.style.display = "none"; // Ocultar campos adicionales de personas
        empresaInput.style.display = "block"; // Mostrar campo empresa
        empresaLabel.style.display = "block"; // Mostrar etiqueta de empresa
        empresaInput.required = true; // Hacer el campo de empresa obligatorio
        valorTotalInput.value = "190000"; // Establecer valor total para Plan 2
    } else {
        extraPersonas.style.display = "block"; // Mostrar campos adicionales de personas
        empresaInput.style.display = "none"; // Ocultar campo empresa
        empresaLabel.style.display = "none"; // Ocultar etiqueta de empresa
        empresaInput.required = false; // Deshabilitar la obligatoriedad del campo de empresa
        empresaInput.value = ""; // Limpiar el valor del campo de empresa si está oculto
        valorTotalInput.value = "290000"; // Establecer valor total para Plan 1 y Plan 3
    }
}

function limpiarCampos() {
    document.getElementById("registro-form").reset();
    mostrarCamposAdicionales(); // Restablecer la visibilidad de los campos según el tipo de plan
}

// Llamar a mostrarCamposAdicionales al cargar la página
document.addEventListener("DOMContentLoaded", function () {
    mostrarCamposAdicionales(); // Llamar al cargar la página para establecer la visibilidad inicial
});

// Agregar evento onchange al select de tipo_plan para actualizar el valor_total
document.getElementById("tipo_plan").addEventListener("change", function() {
    mostrarCamposAdicionales(); // Mostrar u ocultar campos según el tipo de plan seleccionado
});

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
    var url = "loadpl.php";
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
