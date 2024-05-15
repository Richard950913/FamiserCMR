//--------------------------- REDIRIGIR A CLIENTE --------------------------------------------
function redirectToEditClientMain(idTitular) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "get_idclientes.php", true); // Asegúrate de ajustar el path a la ubicación correcta de tu archivo PHP
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var idclientes = xhr.responseText;
                if (idclientes) {
                    window.location.href = '../regcliente/editar_cliente.php?id=' + idclientes;
                } else {
                    alert("No se encontró el cliente.");
                }
            } else {
                alert("Error en la solicitud.");
            }
        }
    };

    xhr.send("numId=" + encodeURIComponent(idTitular));
}
//--------------------------- FIN REDIRIGIR A CLIENTE --------------------------------------------