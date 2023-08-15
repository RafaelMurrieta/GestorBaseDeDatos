// Función para abrir el modal
function openModal() {
    document.getElementById("myModal").style.display = "block";
}

// Función para cerrar el modal
function closeModal() {
    document.getElementById("myModal").style.display = "none";
}

// Función para ejecutar la acción de borrar la base de datos (puedes implementarla según tus necesidades)
function deleteDatabase() {
    console.log("Base de datos borrada correctamente.");
    closeModal();
}




window.addEventListener('DOMContentLoaded', function () {
    console.log("entra a la funcion");
    var vista = '<?php echo $vista; ?>';
    if (vista === 'home' || vista === '') {
        var perfilDiv = document.getElementById('perfil');
        var button = perfilDiv.querySelector('button');
        if (button) {
            perfilDiv.removeChild(button);
        }
    }
});

window.addEventListener('DOMContentLoaded', function () {
    console.log("entra a la funcion");
    var infoTable = '<?php echo $infoTable; ?>';
    if (infotable === 'home' || vista === '') {
        var infoTable = document.getElementById('infoTable');
        var form = perfilDiv.querySelector('button');
        if (button) {
            perfilDiv.removeChild(button);
        }
    }
});

function crearColumnas() {
    const numeroColumnas = document.getElementById('columns').value;
    const contenedorInputs = document.getElementById('inputs_columns');
    contenedorInputs.innerHTML = "";
    for (let i = 0; i < numeroColumnas; i++) {
        const input = document.createElement("input");
        input.type = "text";
        contenedorInputs.appendChild(input);

    }
}

function crearTabla() {
    msg= "Tabla creada correctamente";
}
