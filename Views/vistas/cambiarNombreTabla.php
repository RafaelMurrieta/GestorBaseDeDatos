<?php
include("Controller/conect.php");

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


if (isset($_GET["BD"])) {
    $BD = $_GET["BD"];
}
if (isset($_GET["tablaBD"])) {
    $tabla = $_GET["tablaBD"];
}

include "Views/php/navbar.php";
?>

<div class="title">
    <h1 class="title-home">Base de datos:
        <?php echo $BD ?>
    </h1>
    <h5 class="title-home">Tabla:
        <?php echo $tabla ?>
    </h5>
</div>

<form method="POST"
    action="Controller/changeNameTable.php
    ?tablaBD=<?php echo $tabla ?>
    &BD=<?php echo $BD; ?>
    &usr=<?php echo $usuario; ?>
    &ape=<?php echo $usuarioApe; ?>
    &email=<?php echo $email; ?>
    &pass=<?php echo $pass; ?>">
    <div class="container-form" id="changeName">
        <label for="nuevoNombre">Nuevo Nombre de la Tabla:</label>
        <input type="text" id="nuevoNombre" name="nuevoNombre" required>
        <button type="submit" id="sent">Cambiar Nombre</button>
</form>