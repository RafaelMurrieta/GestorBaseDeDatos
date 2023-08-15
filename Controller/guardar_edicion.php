<?php
// Verificar si el formulario ha sido enviado (se ha hecho clic en el botón "Guardar Cambios")
if ($_SERVER["REQUEST_METHOD"] === "POST") {


    // Verificar si el identificador del registro está presente en el formulario
    if (isset($_POST["ID"])) {
        $idRegistro = $_POST["id_registro"];
        $tabla = $_GET["tabla"];
        $BD = $_GET["BD"];

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
        if (isset($_GET["msg"])) {
            $msg = $_GET["msg"];
        }

        $queryParams = http_build_query([
            'usr' => $usuario,
            'ape' => $usuarioApe,
            'email' => $email,
            'pass' => $pass,
            'tabla' => $tabla,
            'BD' => $BD
        ]);
        // Realizar las operaciones necesarias para guardar los datos editados en la base de datos
        // Asegúrate de tener aquí el código de conexión a la base de datos
        require("conect.php");

        $useBd = "USE $BD";
        mysqli_query($sqlCreacion, $useBd);
        
        

        // Obtener información de las columnas de la tabla
        ///SE QUITO LA S DE $INFOCOLUMNAS PARA EL CONTROL DE ERRORES;
        $infoColumnas= mysqli_fetch_fields(mysqli_query($sqlCreacion, "SELECT * FROM $tabla LIMIT 1"));
        if(!$infoColumnas){
        $error_message = "Error al actualizar el registro.";
        $_POST['error_message'] = $error_message;
        echo $error_message;
        include_once '../Model/InsertarErrores.php';

    }

        // Preparar la consulta SQL para actualizar el registro por su ID
        $query = "UPDATE $tabla SET ";
        $valores = array();

        foreach ($infoColumnas as $columna) {
            $nombreColumna = $columna->name;

            // Verificar si el campo no es autoincrementable y está presente en el formulario
            if ($columna->flags !== MYSQLI_AUTO_INCREMENT_FLAG && isset($_POST[$nombreColumna])) {
                $valorColumna = $_POST[$nombreColumna];

                // Asegurarse de escapar el valor para evitar inyección SQL
                $valorColumna = mysqli_real_escape_string($sqlCreacion, $valorColumna);

                // Agregar la columna y su valor a la consulta de actualización
                $valores[] = "$nombreColumna = '$valorColumna'";
            }
        }

        // Unir los valores separados por comas en la consulta de actualización
        $query .= implode(", ", $valores);
        $query .= " WHERE ID = ?";

        $stmt = mysqli_prepare($sqlCreacion, $query);

        if ($stmt) {
            // Asociar el valor del identificador del registro al parámetro de la consulta
            mysqli_stmt_bind_param($stmt, "i", $idRegistro);

            // Ejecutar la consulta para actualizar el registro
            if (mysqli_stmt_execute($stmt)) {
                // La actualización fue exitosa
                // Puedes redirigir a otra página o mostrar un mensaje de éxito
                // Por ejemplo, redireccionar a la página que muestra los registros actualizados
                $msg = "Registro actualizado correctamente";
                header("Location: ../index.php?vista=tablasBD&tablaBD=$tabla&usr=$usuario&ape=$usuarioApe&email=$email&pass=$pass&BD=$BD&msg=$msg");
                exit();
            } else {
                // Ocurrió un error al actualizar el registro
                // Puedes mostrar un mensaje de error o redirigir a una página de error.
                $error_message = die("Error al actualizar el registro.");
                $_POST['error_message'] = $error_message;
                include_once '../Model/InsertarErrores.php';
            }

            // Cerrar la sentencia preparada
            mysqli_stmt_close($stmt);
        } else {
            // Ocurrió un error al preparar la consulta
            // Puedes mostrar un mensaje de error o redirigir a una página de error.
            $error_message = die("Error al preparar la consulta.");
            $_POST['error_message'] = $error_message;
            include_once '../Model/InsertarErrores.php';
        }

        // Cerrar la conexión a la base de datos
        mysqli_close($sqlCreacion);
    } else {
        // El identificador del registro no está presente en el formulario
        // Puedes mostrar un mensaje de error o redirigir a una página de error.
       $error_message =die("Identificador de registro no proporcionado.");
        $_POST['error_message'] = $error_message;
        include_once '../Model/InsertarErrores.php';
    }
} else {
    // El formulario no ha sido enviado
    // Puedes mostrar un mensaje de error o redirigir a una página de error.
    die("Formulario no enviado.");
}
?>