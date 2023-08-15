
<?php

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
require_once("conect.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nameBd = $_POST['nameBD'];
    $usuario = $_POST['usr'];
    $usuarioApe = $_POST['ape'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $msg = "";

    // Sanitize input data to prevent SQL injection
    //LIMPIA BORRANDO LAS COMILLAS DE LAS VARIABLES
    $nameBd = mysqli_real_escape_string($sqlCreacion, $nameBd);
    $usuario = mysqli_real_escape_string($sqlCreacion, $usuario);
    $usuarioApe = mysqli_real_escape_string($sqlCreacion, $usuarioApe);

    // Check if the database already exists
    $sqlComprobar = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$nameBd'";
    $result = mysqli_query($sqlCreacion, $sqlComprobar);

    // Handle connection and query errors
    if (!$result) {
        echo "Error en la consulta: " . mysqli_error($sqlCreacion);
    } else {
        if (mysqli_num_rows($result) === 0) {
            // Create the database if it doesn't exist
            $createBd = "CREATE DATABASE $nameBd";
            if (mysqli_query($sqlCreacion, $createBd)) {
                mysqli_query($sqlCreacion, "USE $nameBd");
                $msg = "BASE DE DATOS CREADA EXITOSAMENTE";
                header("Location:../index.php?vista=home&usr=$usuario&ape=$usuarioApe&msg=$msg&email=$email&pass=$pass");
                exit; // Make sure to exit after a header redirect
            } else {
                echo "Error al crear la base de datos: " . mysqli_error($sqlCreacion);
            }
        } else {
            $msg = " LA BASE DE DATOS YA EXISTE";
                header("Location:../index.php?vista=home&usr=$usuario&ape=$usuarioApe&msg=$msg");
                exit; // Make sure to exit after a header redirect
        }
    }
}
?>
