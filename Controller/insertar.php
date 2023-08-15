<?php
// Establecer la conexión a la base de datos (asegúrate de reemplazar los valores de conexión con los correctos)
$servername = "localhost";
$username = "Rafael";
$password = "";
$dbname = "borrartabla";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Función para generar nombres y apellidos aleatorios
function generarNombreAleatorio() {
    $nombres = array("Juan", "María", "Pedro", "Elena", "Luis", "Ana", "Carlos", "Laura", "Diego", "Carmen");
    $apellidos = array("Gómez", "Pérez", "Rodríguez", "González", "Martínez", "López", "Sánchez", "Fernández", "Romero", "Torres");
    
    $nombreAleatorio = $nombres[array_rand($nombres)];
    $apellidoAleatorio = $apellidos[array_rand($apellidos)];
    
    return $nombreAleatorio . " " . $apellidoAleatorio;
}

// Generar e insertar 1000 registros aleatorios
for ($i = 0; $i < 90000; $i++) {
    $nombre = generarNombreAleatorio();
    $apellido = generarNombreAleatorio();
    
    $sql = "INSERT INTO prueba (Nombre, Apellido) VALUES ('$nombre', '$apellido')";
    
    if ($conn->query($sql) !== TRUE) {
        echo "Error al insertar el registro número $i: " . $conn->error;
    }else{
        echo "Datos insertados";
    }
}

$conn->close();
?>