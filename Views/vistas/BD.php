<?php

if (isset($_GET["bd"])) {
    $BD = $_GET["bd"];
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
if (isset($_GET["table"])) {
    $table = $_GET["table"];
}
if (isset($_GET["mgs"])) {
    $msg= $_GET["msg"];
}
require("Controller/conect.php");

$usar = "USE $BD";
$tables_query = "SHOW TABLES";
$borrar = "DROP DATABASE $BD";
$msg1 = "BASE DE DATOS BORRADA EXITOSAMENTE";

$tables = array();

if (mysqli_query($sqlCreacion, $usar)) {
    try {
        $result = mysqli_query($sqlCreacion, $tables_query);
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                $tables[] = $row[0];
            }
        }
    } catch (\Throwable $th) {
        //throw $th;
    }
}
include "Views/php/navbar.php";
?>
  <script>
    alert("<?= $msg; ?>");
  </script>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="Views/css/BD.css">
    <title>Tablas en la Base de Datos</title>

</head>

<body>


    <div class="title">
        <h1>Tablas en la Base de Datos:
            <?php echo $BD; ?>
        </h1>

    </div>
    <div class="newTablee">
        <a href="index.php?vista=createtable&BD=<?php echo $BD ?>&usr=<?php echo $usuario ?>&ape=<?php echo $usuarioApe ?>&email=<?php echo $email?>&pass=<?php echo $pass?>"
            id="tableCreate">Crear una tabla
            <img src="Controller/img/table.png" alt="" id="tableIcon">
        </a>
    </div>
    <?php if (count($tables) > 0): ?>
        <table>
            <tr>
                <th>Tablas existentes</th>
                <th>Acciones</th>
                <th>Borrar</th>
                <th>Cambiar nombre</th>
            </tr>
            <?php foreach ($tables as $table): ?>
                <tr>
                    <td>
                        <?php echo $table; ?>
                    </td>
                    <td>
                        <a href="index.php?vista=tablasBD&tablaBD=<?php echo $table ?>&ape=<?php echo $usuarioApe ?>&usr=<?php echo $usuario ?>&BD=<?php echo $BD ?>&email=<?php echo $email?>&pass=<?php echo $pass?>">Ver tabla</a>
                    </td>
                    <td>
                        <a href="index.php?vista=borrarTablas&tablaBD=<?php echo $table ?>&ape=<?php echo $usuarioApe ?>&usr=<?php echo $usuario ?>&BD=<?php echo $BD ?>&email=<?php echo $email?>&pass=<?php echo $pass?>">Borrar tabla</a>
                    </td>
                    <td>
                        <a href="index.php?vista=cambiarNombreTabla&tablaBD=<?php echo $table ?>&BD=<?php echo $BD ?>&email=<?php echo $email?>&pass=<?php echo $pass?>&usr=<?php echo $usuario ?>&ape=<?php echo $usuarioApe ?>">Cambiar nombre
                            tabla</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No se encontraron tablas en la base de datos.</p>
    <?php endif; ?>


    <div class="buttons">
        <button class="deleteBD" onclick="openModal()">
            Borrar base de datos
        </button>
    </div>

    <!-- Modal -->
    <div class="modal" id="myModal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <p>¿Estás seguro de que deseas borrar la base de datos?</p>
            <button class="confirm-delete" onclick="deleteDatabase()">Confirmar</button>
        </div>
    </div>
    


    <script>
        // Función para abrir el modal
        function openModal() {
            document.getElementById("myModal").style.display = "block";
        }

        // Función para cerrar el modal
        function closeModal() {
            document.getElementById("myModal").style.display = "none";
        }

        // Función para ejecutar la acción de borrar la base de datos
        function deleteDatabase() {
            // Enviar una solicitud AJAX al servidor para borrar la base de datos
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {

                    window.location.href = "index.php?vista=home&usr=<?php echo $usuario ?>&ape=<?php echo $usuarioApe ?>&msg= <?php echo $msg1 ?>&email=<?php echo $email?>&pass=<?php echo $pass?>";
                    closeModal();
                }
            };
            xhttp.open("GET", "Controller/borra_basedatos.php?BD=<?php echo $BD ?>&usr=<?php echo $usuario ?>&ape=<?php echo $usuarioApe ?>&email=<?php echo $email?>&pass=<?php echo $pass?>", true);
            xhttp.send();
        }

    </script>
</body>

</html>