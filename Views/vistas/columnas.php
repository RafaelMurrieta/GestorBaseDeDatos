<?php
if (isset($_GET["bd"])) {
    $BD = $_GET["bd"];
}
if (isset($_GET["tabla"])) {
    $tabla = $_GET["tabla"];
}
// Simulación de conexión a la base de datos (NO USAR EN PRODUCCIÓN)
$host = 'localhost';
$username = 'Rafael';
$password = '';

// Conexión a la base de datos
$conn = mysqli_connect($host, $username, $password, $BD);

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Obtener el nombre de la tabla enviada como parámetro GET


// Consulta SQL para obtener las columnas de la tabla
$sql = "SHOW COLUMNS FROM $tabla";

// Ejecutar la consulta
$resultado = mysqli_query($conn, $sql);

// Comprobar si se obtuvieron resultados
if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conn));
}

// Crear un arreglo para almacenar los nombres de las columnas
$columnas = array();

// Obtener los nombres de las columnas y agregarlos al arreglo
while ($fila = mysqli_fetch_assoc($resultado)) {
    $columnas[] = $fila["Field"];
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);

// Devolver el arreglo de columnas en formato JSON
header("Content-Type: application/json");
echo json_encode($columnas);
?>
