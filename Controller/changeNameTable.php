<?php
// Supongamos que ya has establecido la conexión a la base de datos en $sqlCreacion

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
    $BD = trim($_GET["BD"]); // Elimina espacios en blanco al inicio y final del nombre
}
if (isset($_GET["tablaBD"])) {
    $tabla = $_GET["tablaBD"];
}


$nuevoNombre = $_POST['nuevoNombre'];

if ($nuevoNombre) {
    include "conect.php";

    if (!$sqlCreacion) {
        echo "Error al conectar a la base de datos: " . mysqli_connect_error();
        exit;
    }

    // Escapa correctamente los datos antes de utilizarlos en la consulta
    $cambioNombre = mysqli_real_escape_string($sqlCreacion, $nuevoNombre);

    // Asegúrate de que las variables $tabla y $BD no sean nulas antes de utilizarlas en la consulta
    if (isset($tabla) && isset($BD)) {
        // Elimina espacios en blanco al inicio y final del nombre de la base de datos y la tabla
        $BD = trim($BD);
        $tabla = trim($tabla);
    
        $rename = "RENAME TABLE `$BD`.`$tabla` TO `$BD`.`$cambioNombre`;";
        $use = "USE `$BD`";
    
        // Ejecutar la consulta para cambiar el nombre de la tabla
        if (mysqli_query($sqlCreacion, $use)) {
            echo "base de datos ".$BD;
            $change = mysqli_query($sqlCreacion, $rename);
            if (!$change) {
                echo "<script>alert('Error al cambiar el nombre de la tabla');</script>";
            } else {
                $msg = "Cambio de nombre de la tabla con éxito.";
                echo "<script> window.location.href='../../index.php?vista=BD&bd=$BD&msg=$msg&usr=$usuario&ape=$usuarioApe&email=$email&pass=$pass&table=$cambioNombre'; </script>";
               header("Location: ../index.php?vista=BD&bd=$BD&msg=$msg&usr=$usuario&ape=$usuarioApe&email=$email&pass=$pass&table=$cambioNombre");
                exit;
            }
        } else {
            echo "Error al seleccionar la base de datos: " . $BD . " " . mysqli_error($sqlCreacion);
            echo "base de datos NO CONECTADOOO ".$BD;
        }
    } else {
        echo "Faltan datos para cambiar el nombre de la tabla.";
    }

    // Cerrar conexión
    mysqli_close($sqlCreacion);
}
?>
