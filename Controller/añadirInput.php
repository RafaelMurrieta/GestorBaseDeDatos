<?php
// Verificar si se han enviado los datos mediante POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET["BD"]) && isset($_GET["tabla"])) {
    // Obtener los datos enviados desde el formulario
    $BD = $_GET["BD"];
    $tabla = $_GET["tabla"];
    $datos = $_POST["columnas"]; // Datos ingresados por el usuario desde los inputs

    // Conectarse a la base de datos
    require("conect.php");

    $useBd = "USE $BD";
    mysqli_query($sqlCreacion, $useBd);

    // Generar la consulta de inserción
    $columnas = implode(", ", array_keys($datos));
    $valores = "'" . implode("', '", $datos) . "'";
    $query = "INSERT INTO $tabla ($columnas) VALUES ($valores)";

    // Ejecutar la consulta de inserción
    try {
        $resultado = mysqli_query($sqlCreacion, $query);
        if ($resultado) {
            echo "Datos insertados correctamente en la tabla $tabla.";
        } else {
            echo "Error al insertar datos en la tabla $tabla.";
        }
    } catch (\Throwable $th) {
        echo "Error en la operación: " . $th->getMessage();
    }
} else {
    echo "Error: Datos insuficientes para realizar la inserción.";
}
