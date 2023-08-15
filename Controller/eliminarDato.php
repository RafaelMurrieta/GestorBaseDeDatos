<?php
// Verificar si el identificador del registro está presente en la URL
if (isset($_GET["ID"])) {
    // Obtener el identificador del registro a eliminar
    $idRegistro = intval($_GET["ID"]); // Convertir a entero para mayor seguridad

    // Obtener la base de datos y tabla desde la URL
    $BD = $_GET["bd"];
    $tabla = $_GET["tabla"];

    // Realizar las operaciones necesarias para eliminar el registro de la base de datos
    // Asegúrate de tener aquí el código de conexión a la base de datos
    require("conect.php");

    $usebd = "USE $BD";
    mysqli_query($sqlCreacion, $usebd);

    // Preparar la consulta SQL para eliminar el registro
    $query = "DELETE FROM $tabla WHERE ID = ?";
    $stmt = mysqli_prepare($sqlCreacion, $query);

    if ($stmt) {
        // Asociar el valor del identificador del registro al parámetro de la consulta
        mysqli_stmt_bind_param($stmt, "i", $idRegistro);

        // Ejecutar la consulta para eliminar el registro
        if (mysqli_stmt_execute($stmt)) {
            // Verificar si se eliminó alguna fila (registro)
            $numFilasEliminadas = mysqli_stmt_affected_rows($stmt);

            if ($numFilasEliminadas > 0) {
                // El registro fue eliminado exitosamente
                // Puedes enviar una respuesta JSON de éxito si lo deseas
                http_response_code(200);
                echo json_encode(array("message" => "Registro eliminado exitosamente."));
            } else {
                // El registro no existía o no se eliminó correctamente
                // Puedes enviar una respuesta JSON de error si lo deseas
                http_response_code(404); // Código de recurso no encontrado
                echo json_encode(array("message" => "Registro no encontrado."));
            }
        } else {
            // Ocurrió un error al eliminar el registro
            // Puedes enviar una respuesta JSON de error si lo deseas
            http_response_code(500); // Código de error del servidor
            echo json_encode(array("message" => "Error al eliminar el registro."));
        }

        // Cerrar la sentencia preparada
        mysqli_stmt_close($stmt);
    } else {
        // Ocurrió un error al preparar la consulta
        // Puedes enviar una respuesta JSON de error si lo deseas
        http_response_code(500); // Código de error del servidor
        echo json_encode(array("message" => "Error al preparar la consulta."));
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($sqlCreacion);
} else {
    // El identificador del registro no está presente en la URL
    // Puedes enviar una respuesta JSON de error si lo deseas
    http_response_code(400); // Código de solicitud incorrecta
    echo json_encode(array("message" => "Identificador de registro no proporcionado."));
}
?>
