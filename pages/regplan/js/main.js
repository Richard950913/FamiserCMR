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

