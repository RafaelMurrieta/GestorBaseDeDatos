<?php
if (isset($_GET["BD"])) {
    $BD = $_GET["BD"];
}
if (isset($_GET["tabla"])) {
    $tabla = $_GET["tabla"];
}

require("Controller/conect.php");
include "Views/php/navbar.php";

?>

<script>
    alert("<?= $msg; ?>");
</script>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="Views/css/BD.css">
</head>

<body>
    <div class="title">
        <h1>Tabla: <?php echo $tabla; ?></h1>
    </div>

    <div class="newTablee"></div>

    <?php
    $useBd = "USE $BD";
    $selectTable = "SELECT * FROM $tabla";
    try {
        // Ejecuta la consulta "USE" para seleccionar la base de datos deseada
        $usarBD = mysqli_query($sqlCreacion, $useBd);
        if ($usarBD) {
            // Ejecuta la consulta "SELECT" para obtener los datos de la tabla
            $showTabla = mysqli_query($sqlCreacion, $selectTable);
            if ($showTabla) {
                $columnas = array();
                $autoIncrementables = array();
                echo "<table id='miTabla'>";
                echo "<tr>";
                // Obtiene los nombres de las columnas y los muestra en la primera fila de la tabla
                while ($infoColumnas = mysqli_fetch_field($showTabla)) {
                    echo "<th>" . htmlspecialchars($infoColumnas->name) . "</th>";
                    $columnas[] = $infoColumnas->name;
                    if ($infoColumnas->flags & MYSQLI_AUTO_INCREMENT_FLAG) {
                        $autoIncrementables[] = $infoColumnas->name;
                    }
                }
                echo "</tr>";

                // Muestra los datos de cada fila en la tabla
                while ($row = mysqli_fetch_assoc($showTabla)) {
                    echo "<tr>";
                    // Recorre cada columna de la fila y muestra su valor
                    foreach ($columnas as $columna) {
                        echo "<td>" . htmlspecialchars($row[$columna]) . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            }
        }
    } catch (\Throwable $th) {
        // Maneja cualquier excepción o error aquí
    }
    ?>

    <!-- Agregar una columna adicional para permitir la inserción de datos -->
    <div class="inputs-llenar" id="inputs-llenar">
        <?php
        // Generar inputs dinámicamente según el número de columnas no autoincrementables
        foreach ($columnas as $columna) {
            if (!in_array($columna, $autoIncrementables)) {
                echo "<label>Ingrese el dato para: $columna</label>";

                // Obtiene el tipo de dato de la columna en la base de datos
                $queryGetColumnType = "SHOW COLUMNS FROM $tabla WHERE Field = '$columna'";
                $resultGetColumnType = mysqli_query($sqlCreacion, $queryGetColumnType);
                $columnType = mysqli_fetch_assoc($resultGetColumnType)["Type"];

                // Genera el input adecuado según el tipo de dato de la columna
                if (strpos($columnType, "int") !== false) {
                    echo "<input type='number' name='columnas[$columna]'><br>";
                } else {
                    echo "<input type='text' name='columnas[$columna]'><br>";
                }
            }
        }
        ?>
    </div>
    <button type="button" id="sent">Llenar datos</button>

    <!-- Agregar el script AJAX para enviar los datos al servidor -->
    <script>



        document.getElementById("sent").addEventListener("click", function () {
            const formData = new FormData();
            const inputs = document.querySelectorAll(".inputs-llenar input");
            inputs.forEach(input => {
                formData.append(input.name, input.value);
            });

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "Controller/añadirInput.php?usr=<?php echo $usuario; ?>&BD=<?php echo $BD; ?>&ape=<?php echo $usuarioApe; ?>&email=<?php echo $email; ?>&pass=<?php echo $pass; ?>&tabla=<?php echo $tabla; ?>", true);

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                    // Si deseas actualizar la tabla después de la inserción, puedes hacerlo aquí
                    // Por ejemplo, puedes llamar a una función que actualice los datos de la tabla
                }
            };

            xhr.send(formData);
        });
        
    </script>
    
</body>

</html>
