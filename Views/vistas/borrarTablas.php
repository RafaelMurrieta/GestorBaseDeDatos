    <?php
// Supongamos que ya has establecido la conexión a la base de datos en $sqlCreacion
include("../../Controller/conect.php");

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

$sqlBorrar = "DROP TABLE `$tabla`";

// Ejecutar la consulta para borrar la tabla
if ($sqlCreacion->query("USE $BD") === TRUE) {
    if ($sqlCreacion->query($sqlBorrar) === TRUE) {
        echo "Tabla borrada correctamente.";

        echo "<script> window.location.href='../index.php?vista=BD&bd=$BD&usr=$usuario&ape=$usuarioApe&email=$email&pass=$pass'; </script>";
        header("Location: index.php?vista=BD&bd=$BD&usr=$usuario&ape=$usuarioApe&email=$email&pass=$pass");
        die();
    } else {
        echo "Error al borrar la Tabla: " . $tabla . " " . $sqlCreacion->error;
    }
} else {
    echo "Error al seleccionar la base de datos: " . $BD . " " . $sqlCreacion->error;
}

// Cerrar conexión
$sqlCreacion->close();

// Cerrar conexión
$sqlCreacion->close();
?>

