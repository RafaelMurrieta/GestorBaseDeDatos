<?php
// Conexión a la base de datos (usando tus datos de conexión)
// Obtener las tablas de la base de datos
if (isset($_GET["bd"])) {
    $BD = $_GET["bd"];
}
$host = "localhost";
$usr = "Rafael";
$pwd = "";


$conn = new mysqli($host, $usr, $pwd, $BD);

$query = "SHOW TABLES";
$result = $conn->query($query);

$tablas = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tablas[] = $row["Tables_in_" . $BD];
    }
}

// Cerrar la conexión
$conn->close();

// Enviar la respuesta como un JSON válido
header('Content-Type: application/json');
echo json_encode($tablas);
?>
