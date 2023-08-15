<?php
require_once("../Views/php/valitation.php");
require_once("conexion.php");
$BR = "<br>";

if (isset($_GET["email"])) {
    $lastEmail = $_GET["email"];
}
if (isset($_GET["pass"])) {
    $lastPass = $_GET["pass"];
}

// Obtener los datos enviados por el formulario
if (isset($_POST['newName'], $_POST['NewlastName'], $_POST['Newemail'], $_POST['Newpassword'])) {
    $name = limpiar_cadena($_POST['newName']);
    $lastName = limpiar_cadena($_POST['NewlastName']);
    $email = limpiar_cadena($_POST['Newemail']);
    $password = $_POST['Newpassword'];

    // Verificar que los datos no estén vacíos
    if (empty($email) || empty($password)) {
        $msg = "NO SE PUEDE ACTUALIZAR SI NO HAY DATOS";
        header("Location: ../../index.php?vista=home&msg=$msg");
        exit();
    }

    // Actualizar los datos del usuario utilizando una declaración preparada
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sqlUpdate = "UPDATE users SET Nombre=?, Apellido=?, Email=?, `Contraseña`=? WHERE Email=?";
    $stmt = mysqli_prepare($conexion, $sqlUpdate);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssss", $name, $lastName, $email, $hashedPassword, $lastEmail);
        if (mysqli_stmt_execute($stmt)) {
            // La actualización se realizó con éxito
            $msg = "DATOS ACTUALIZADOS";
            header("Location: ../index.php?msg=$msg");
        } else {
            // Hubo un error en la actualización
            $msg = "DATOS NO ACTUALIZADOS";
            header("Location: ../index.php?vista=home&msg=$msg");
        }
        // Cerrar la declaración preparada
        mysqli_stmt_close($stmt);
    } else {
        // Hubo un error en la preparación de la consulta
        $msg = "ERROR EN LA CONSULTA";
        header("Location: ../index.php?vista=home&msg=$msg");
    }

    // Cerrar la conexión
    mysqli_close($conexion);

} else {
    // Redirigir si no se enviaron los datos del formulario
    $msg = "ERROR";
    header("Location: ../index.php?vista=home");
}
?>
