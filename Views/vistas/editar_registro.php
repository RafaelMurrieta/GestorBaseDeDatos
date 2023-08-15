<?php
$idRegistro = $_GET["ID"];
$tabla = $_GET["tabla"];
$BD = $_GET["BD"];
if (isset($_GET['vista'])) {
   $vista = $_GET['vista'];
}

include "Views/php/navbar.php";
?>
<!DOCTYPE html>
<html>

<head>
    <title>Editar Registro</title>
</head>

<body>

    <div class="title">
    <h1 class="title-home">Editar registros
    </h1>
    <h2 class="title-home">Tabla:
        <?php echo $tabla ?>
    </h2>
    <script>
        alert("<?= $msg; ?>");
    </script>
</div>
    <?php ?>
    
    <form action="Controller/guardar_edicion.php?ID= <?php echo $idRegistro ?>&tabla= <?php echo $tabla ?>&BD= <?php echo $BD ?>" method="post">
    <div class="tablaContainer">
        <?php
        // Verificar si el identificador del registro está presente en la URL
        if (isset($_GET["ID"])) {
            $idRegistro = $_GET["ID"];
            $tabla = $_GET["tabla"];
            $BD = $_GET["BD"];

            $useBd = "USE $BD";

            // Realizar las operaciones necesarias para obtener los datos del registro de la base de datos
            // Asegúrate de tener aquí el código de conexión a la base de datos
            require("Controller/conect.php");

            mysqli_query($sqlCreacion, $useBd);

            // Preparar la consulta SQL para obtener los datos del registro por su ID
            $query = "SELECT * FROM $tabla WHERE ID = ?";
            $stmt = mysqli_prepare($sqlCreacion, $query);

            if ($stmt) {
                // Asociar el valor del identificador del registro al parámetro de la consulta
                mysqli_stmt_bind_param($stmt, "i", $idRegistro);

                // Ejecutar la consulta para obtener los datos del registro
                mysqli_stmt_execute($stmt);

                // Obtener los resultados de la consulta
                $resultado = mysqli_stmt_get_result($stmt);

                if ($resultado && mysqli_num_rows($resultado) === 1) {
                    // Se encontró el registro, obtener los datos
                    $registro = mysqli_fetch_assoc($resultado);

                    // Obtener información de las columnas de la tabla
                    $infoColumnas = mysqli_fetch_fields(mysqli_query($sqlCreacion, "SELECT * FROM $tabla LIMIT 1"));

                    // Cerrar la sentencia preparada
                    mysqli_stmt_close($stmt);

                    // Cerrar la conexión a la base de datos
                    mysqli_close($sqlCreacion);

                    // Recorrer las columnas y generar los inputs solo para las columnas que no sean autoincrementables
                    foreach ($infoColumnas as $columna) {
                        if ($columna->flags !== MYSQLI_AUTO_INCREMENT_FLAG) {
                            $nombreColumna = $columna->name;
                            $valorColumna = htmlspecialchars($registro[$nombreColumna]);
                            echo "<label for='$nombreColumna'>$nombreColumna:</label>";
                            echo "<input type='text' id='$nombreColumna' name='$nombreColumna' value='$valorColumna'><br>";
                        }
                    }
                } else {
                    // El registro no existe o hay más de un registro con el mismo ID (error inesperado)
                    // Puedes mostrar un mensaje de error o redirigir a una página de error.
                    die("Error: No se encontró el registro.");
                }
            } else {
                // Ocurrió un error al preparar la consulta
                // Puedes mostrar un mensaje de error o redirigir a una página de error.
                die("Error al preparar la consulta.");
            }
        } else {
            // El identificador del registro no está presente en la URL
            // Puedes mostrar un mensaje de error o redirigir a una página de error.
            die("Identificador de registro no proporcionado.");
        }
        ?>

        <!-- Agregar más inputs para otros campos del registro según sea necesario -->

        <input type="hidden" name="id_registro" value="<?php echo $idRegistro; ?>">
        <input type="submit" value="Guardar Cambios" id="sent2" >
        </div>
    </form>
    
</body>

</html>