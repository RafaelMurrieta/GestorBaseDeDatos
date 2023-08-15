<?php
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
$newUser = $_POST['newName'];
$newEmail = $_POST['Newemail'];
$newPass = $_POST['Newpassword'];
$newlastName = $_POST['NewlastName'];

// Validación y limpieza de datos
$newUser = filter_input(INPUT_POST, 'newName', FILTER_SANITIZE_STRING);
$newEmail = filter_input(INPUT_POST, 'Newemail', FILTER_SANITIZE_EMAIL);
$newPass = filter_input(INPUT_POST, 'Newpassword', FILTER_SANITIZE_STRING);
$newlastName = filter_input(INPUT_POST, 'NewlastName', FILTER_SANITIZE_STRING);

// Hashear la contraseña


// Hashear la contraseña
$NewPass = hash("md5", $newPass);


include "conexion.php";

// Consulta SQL con Prepared Statement
$sql = "INSERT INTO users (Nombre, Apellido, Email, Contraseña) VALUES (?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssss", $newUser, $newlastName, $newEmail, $NewPass);

if ($stmt->execute()) {
    $msg = "Usuario creado correctamente";
    $queryParams = http_build_query([
        'vista' => 'home',
        'usr' => $usuario,
        'ape' => $usuarioApe,
        'email' => $email,
        'pass' => $pass
    ]);
    header("Location: ../index.php?vista=home&$queryParams&msg=$msg");
    die();
} else {
    // Registrar el error en un archivo de log o en otro medio seguro
    error_log("Error al insertar datos: " . $stmt->error);
    $msg = "Ha ocurrido un error al crear el usuario. Por favor, inténtelo de nuevo más tarde.";
    header("Location: ../index.php?vista=home&msg=$msg");
    die();
}

// Cerrar la conexión
$stmt->close();
$conexion->close();



//ENCRIPTAR CONTRASEÑAAAAAAAAAAAAAAAAAAAAAAAAAS
?>