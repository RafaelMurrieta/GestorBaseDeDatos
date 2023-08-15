<?php

if (isset($_GET["BD"])) {
    $BD = $_GET["BD"];
}

if (isset($_GET["nameTable"])) {
    $nameTable = $_GET["nameTable"];
}

if (isset($_GET["msg"])) {
    $msg = $_GET["msg"];
}
if (isset($_GET["usr"])) {
    $usuario = $_GET["usr"];
}
if (isset($_GET["ape"])) {
    $usuarioApe = $_GET["ape"];
}
if (isset($_GET["email"])) {
    $email = $_GET["email"];
}
if (isset($_GET["pass"])) {
    $pass = $_GET["pass"];
}
include "Views/php/navbar.php";
// Incluir la función que obtiene las tablas

?>
<script>
    alert("<?= $msg; ?>");
</script>
<div class="title">
    <h1 class="title-home">Base de datos:
        <?php echo $BD ?>
    </h1>
</div>
<link rel="stylesheet" href="../css/BD.css">
<form method="POST"
    action="Controller/crearTabla.php?bd=<?php echo $BD; ?>&usr=<?php echo $usuario; ?>&ape=<?php echo $usuarioApe; ?>&email=<?php echo $email; ?>&pass=<?php echo $pass; ?>">

    <div class="container-form">

        <label for="tabla">Nombre de la tabla:</label>
        <input type="text" id="tabla" name="tabla" required>
        <br>
        <label for="num_columnas">Número de columnas:</label>
        <input type="number" id="num_columnas" name="num_columnas" min="1" max="10" required>
        <br>
        <br>
        <button type="button" id="sent" onclick="crearColumnas()">Crear columnas</button>

        <label for="mostrarTablas">Marque la casilla si quiere referenciar alguna tabla </label>
        <input type="checkbox" id="mostrarTablas">
        <select id="tablaSelect" name="tableReference"></select>
        <label for="columnaSelect">Seleccione la columna de referencia:</label>
        <select id="columnaSelect" name="columnReference"></select>


        <div id="opcionesTablas"></div>



    </div>
    <br>
    <div class="container-form" id="inputs_columns">
        <!-- Aquí se agregarán las filas de tabla -->
    </div>

    <div class="Referenciar">

    </div>
    <!-- Mover el botón "Crear tabla" dentro del formulario -->
    <button type="submit" id="sent2">Crear tabla</button>
</form>
<!-- Agrega un elemento con el atributo data-bd -->
<div id="bd" data-bd="<?php echo $BD; ?>"></div>

<script>

document.getElementById("tablaSelect").addEventListener("change", function () {
        const tablaSelect = document.getElementById("tablaSelect");
        const columnaSelect = document.getElementById("columnaSelect");
        const tablaSeleccionada = tablaSelect.value;

        if (tablaSeleccionada !== "") {
            fetch(`Views/vistas/columnas.php?bd=<?php echo $BD; ?>&tabla=${tablaSeleccionada}`)
                .then(response => response.json())
                .then(data => {
                    columnaSelect.innerHTML = ""; // Limpiar el select antes de agregar opciones
                    data.forEach(columna => {
                        const option = document.createElement("option");
                        option.text = columna;
                        columnaSelect.add(option);
                    });
                })
                .catch(error => {
                    console.error("Error al obtener las columnas:", error);
                });
        } else {
            columnaSelect.innerHTML = ""; // Limpiar el select de columnas si no hay tabla seleccionada
        }
    });

    document.getElementById("mostrarTablas").addEventListener("change", function () {
        console.log("llega");
        const tablaSelect = document.getElementById("tablaSelect");
        if (this.checked) {
            console.log("llega a");
            // Hacer una solicitud al servidor para obtener la lista de tablas
            fetch("Views/vistas/tablas.php?bd=<?php echo $BD; ?>")
                .then(response => {
                    console.log("Respuesta del servidor:", response);
                    return response.json();
                })
                .then(data => {
                    console.log("llega aqu");
                    // Suponiendo que "data" es un arreglo de nombres de tablas
                    tablaSelect.innerHTML = ""; // Limpiar el select antes de agregar opciones
                    data.forEach(tabla => {
                        const option = document.createElement("option");
                        option.text = tabla;
                        tablaSelect.add(option);
                        console.log("llega aqui");
                    });
                })
                .catch(error => {
                    console.error("Error al obtener las tablas:", error);
                });
        } else {
            tablaSelect.innerHTML = ""; // Limpiar el select si se desmarca el checkbox
        }
    });

    document.getElementById("tablaSelect").addEventListener("change", function () {
        const tablaSelect = document.getElementById("tablaSelect");
        const columnaSelect = document.getElementById("columnaSelect");
        const tablaSeleccionada = tablaSelect.value;

        if (tablaSeleccionada !== "") {
            console.log("primero");
            fetch(`Views/vistas/columnas.php?bd=<?php echo $BD; ?>&tabla=${tablaSeleccionada}`)
                .then(response => response.json())
                .then(data => {
                    console.log("Columnas recibidas:", data); // Agrega este mensaje de consola
                    columnaSelect.innerHTML = ""; // Limpiar el select antes de agregar opciones
                    data.forEach(columna => {
                        const option = document.createElement("option");
                        option.text = columna;
                        columnaSelect.add(option);
                    });
                })
                .catch(error => {
                    console.error("Error al obtener las columnas:", error);
                });
        } else {
            columnaSelect.innerHTML = ""; // Limpiar el select de columnas si no hay tabla seleccionada
        }
    });

    function crearColumnas() {
        const numeroColumnas = document.getElementById('num_columnas').value;
        const contenedorInputs = document.getElementById('inputs_columns');
        contenedorInputs.innerHTML = "";

        // Crear las filas de la tabla
        for (let i = 0; i < numeroColumnas; i++) {
            const fila = document.createElement("div");

            // Crear el menú para cada fila
            const menuOpciones = document.createElement("div");
            menuOpciones.classList.add("menu");
            menuOpciones.innerHTML = `
                <label for="columna_${i}">Nombre de la columna:</label>
                <input type="text" name="columna_${i}" required>
                <label for="opcion_${i}">Tipo de dato:</label>
                <select name="opcion_${i}" id="opcion_${i}">
                    <option value="INT">INT</option>
                    <option value="VARCHAR">VARCHAR</option>
                    <option value="FLOAT">FLOAT</option>
                </select>
                <select name="indice_${i}" id="indice_${i}">
                    <option value="">Sin valor</option>
                    <option value="PRIMARY KEY">PRIMARY KEY</option>
                    <option value="UNIQUE">UNIQUE</option>
                    <option value="INDEX">Index</option>
                    <option value="FULLTEXT">Fulltext Index</option>
                    <option value="SPATIAL INDEX">Spatial Index</option>
                </select>
                <label for="autoincrement_${i}">AI:</label>
                <input type="checkbox" name="autoincrement_${i}">
            `;
            fila.appendChild(menuOpciones);

            // Agregar la fila al contenedor
            contenedorInputs.appendChild(fila);
        }
    }
</script>