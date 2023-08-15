<?php
// Obtener los valores enviados desde el formulario
$BD = $_GET["bd"];
$usuario = $_GET["usr"];
$usuarioApe = $_GET["ape"];
$email = $_GET["email"];
$pass = $_GET["pass"];

// Conexión a la base de datos (cambia los valores por los tuyos)
include("conect.php");

// Verificar la conexión
if ($sqlCreacion->connect_error) {
    $msg = "Error en la conexion";
    header("Location: ../index.php?vista=BD&bd=$BD&usr=$usuario&ape=$usuarioApe&email=$email&pass=$pass&msg=$msg");
    die("Error en la conexión: " . $sqlCreacion->connect_error);
}

// Seleccionar la base de datos
if (!$sqlCreacion->select_db($BD)) {
    $msg = "Error al seleccionar la base de datos" . $sqlCreacion->connect_error;
    header("Location: ../index.php?vista=BD&bd=$BD&usr=$usuario&ape=$usuarioApe&email=$email&pass=$pass&msg=$msg");
    die("Error al seleccionar la base de datos: " . $sqlCreacion->error);
}

// Obtener los datos del formulario para la tabla
$nombreTabla = $_POST["tabla"];
$numColumnas = $_POST["num_columnas"];
$tableReference = isset($_POST['tableReference']) ? $_POST['tableReference'] : "";
$columnReference = isset($_POST['columnReference']) ? $_POST['columnReference'] : "";

$tablaExisteQuery = "SELECT EXISTS (SELECT 1 FROM information_schema.tables WHERE table_schema = '$BD' AND table_name = '$nombreTabla')";
$tablaExisteResult = $sqlCreacion->query($tablaExisteQuery);
if ($tablaExisteResult) {
    $tablaExiste = $tablaExisteResult->fetch_row()[0];
    if ($tablaExiste) {
        $msg = "La tabla '$nombreTabla' ya existe en la base de datos.";
        header("Location: ../index.php?vista=BD&bd=$BD&usr=$usuario&ape=$usuarioApe&email=$email&pass=$pass&msg=$msg");

    } else {

        // Crear el query para crear la tabla
        $sql = "CREATE TABLE `$nombreTabla` (";

        // Bandera para indicar si ya se ha agregado alguna columna
        $primeraColumna = true;

        // Obtener los nombres y tipos de las columnas desde el formulario
        for ($i = 0; $i < $numColumnas; $i++) {
            $nombreColumna = isset($_POST["columna_" . $i]) ? $_POST["columna_" . $i] : "";
            $tipoDato = isset($_POST["opcion_" . $i]) ? $_POST["opcion_" . $i] : "";
            $tipoIndice = isset($_POST["indice_" . $i]) ? $_POST["indice_" . $i] : ""; // Tipo de índice seleccionado
            $autoIncrement = isset($_POST["autoincrement_" . $i]) ? true : false; // Verificar si es autoincremental


            // Validar que los datos no estén vacíos y que el tipo de dato sea válido
            if (!empty($nombreColumna) && in_array($tipoDato, array("INT", "VARCHAR", "FLOAT"))) {
                // Escapar los nombres de columna y tipo de dato para evitar inyección de SQL (opcional)
                $nombreColumna = mysqli_real_escape_string($sqlCreacion, $nombreColumna);
                $tipoDato = mysqli_real_escape_string($sqlCreacion, $tipoDato);
                $tipoIndice = mysqli_real_escape_string($sqlCreacion, $tipoIndice);

                // Agregar la columna al query
                if (!$primeraColumna) {
                    $sql .= ", ";
                }
                if ($tipoDato === 'VARCHAR') {
                    $sql .= "`$nombreColumna` VARCHAR(50)";
                } else if ($tipoDato === "FLOAT") {
                    $sql .= "`$nombreColumna` FLOAT(10, 2)";
                } else {
                    $sql .= "`$nombreColumna` $tipoDato";
                }

                // Agregar el tipo de índice
                if (!empty($tipoIndice)) {
                    $sql .= " $tipoIndice";
                }

                // Agregar AUTO_INCREMENT si es necesario
                if ($autoIncrement) {
                    $sql .= " AUTO_INCREMENT";
                }
                if (!empty($tableReference) && !empty($columnReference)) {
                    $sql .= ", FOREIGN KEY (`$nombreColumna`) REFERENCES $tableReference(`$columnReference`) ON DELETE CASCADE";
                }




                $primeraColumna = false;
            }else{
                $msg = "Foreign key constraint is incorrectly formed: " . $sqlCreacion->error;
                header("Location: ../index.php?vista=BD&bd=$BD&usr=$usuario&ape=$usuarioApe&email=$email&pass=$pass&msg=$msg");
            }
            echo "Columna $i: Nombre=$nombreColumna, TipoDato=$tipoDato, TipoIndice=$tipoIndice, AutoIncrement=$autoIncrement<br>";

        }

        $sql .= ");";

        // Después de construir el query, imprime el valor de $sql
        echo $sql;

        // Ejecutar el query
        if ($sqlCreacion->query($sql) === TRUE) {
            $msg = "Tabla creada exitosamente";
            header("Location: ../index.php?vista=BD&bd=$BD&usr=$usuario&ape=$usuarioApe&email=$email&pass=$pass&msg=$msg");
        } else {
            $msg = "Error al crear la tabla: " . $sqlCreacion->error;
            header("Location: ../index.php?vista=BD&bd=$BD&usr=$usuario&ape=$usuarioApe&email=$email&pass=$pass&msg=$msg");
        }
    }

} else {
    // Manejar el error de consulta si es necesario
    $msg = "Error al verificar la existencia de la tabla: " . $sqlCreacion->error;
    header("Location: ../index.php?vista=BD&bd=$BD&usr=$usuario&ape=$usuarioApe&email=$email&pass=$pass&msg=$msg");
    // Puedes redirigir o mostrar un mensaje de error al usuario
}

// Cerrar la conexión
$sqlCreacion->close();
?>