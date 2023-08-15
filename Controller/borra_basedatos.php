<?php
require ("conect.php");

if (isset($_GET["usr"])) {
    $usuario = $_GET["usr"];
  }
  if (isset($_GET["BD"])) {
    $BD = $_GET["BD"];
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
// Consulta para borrar la base de datos (reemplaza esto con tu propia consulta)
$sqlBorrar = "DROP DATABASE $BD";

// Ejecutar la consulta para borrar la base de datos
if ($sqlCreacion->query($sqlBorrar) === TRUE) {
    echo "Base de datos borrada correctamente.";
    echo "<script> window.location.href='../index.php?vista=home&usr=$usuario&ape=$usuarioApe&email=$email&pass=$pass'; </script>";
    header("Location: index.php?vista=home&usr=$usuario&ape=$usuarioApe&email=$email&pass=$pass");
    die();
} else {
    echo "Error al borrar la base de datos: " . $sqlCreacion-> mysqli_error($sqlCreacion);
}

// Cerrar conexión
$sqlCreacion->close();

//Con esta corrección, ahora la función deleteDatabase() enviará una solicitud AJAX al servidor, que ejecutará el código PHP para borrar la base de datos. 
//El resultado se mostrará en la consola del navegador.
?>

