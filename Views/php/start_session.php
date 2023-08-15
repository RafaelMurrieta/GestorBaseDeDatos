<?php
session_start();
//require "Controller/conexion.php";
require_once("valitation.php");
/*== Almacenando datos ==*/
$usuarios = limpiar_cadena($_POST['usuario']);
$clave = $_POST['clave'];

$ip = $_SERVER['REMOTE_ADDR'];
$response = $_POST['g-recaptcha-response'];
$secretKey = '';

$respuesta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$captcha&remoteip=$ip");

$secretKey = '6LdQj4wnAAAAAFkO8XuP8h6Mhc52O4JKyghWwHAI';


// Verifica la respuesta del CAPTCHA con la API de reCAPTCHA de Google
$url = 'https://www.google.com/recaptcha/api/siteverify';
$data = array(
    'secret' => $secretKey,
    'response' => $response
);

$options = array(
    'http' => array(
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($data)
    )
);

$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);
$captchaResponse = json_decode($result, true);

if (!$captchaResponse['success']) {
    // La validación del CAPTCHA ha fallado
    $msg = "La validación del CAPTCHA ha fallado. Por favor, inténtalo de nuevo.";
    header("Location: ../../index.php?msg=" . urlencode($msg));
    exit();
}
   
$clave = hash("md5",$clave);



/*== Verificando campos obligatorios ==*/
if ($usuarios == "" || $clave == "") {
    echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    No has llenado todos los campos que son obligatorios
                </div>
            ';
    exit();
}
/*== Verificando integridad de los datos ==*/
if (verificar_datos("[a-zA-Z0-9]{4,20}", $usuarios)) {
    echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El USUARIO no coincide con el formato solicitado
                </div>
            ';
    exit();
}

/*
if(verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave)){
    $msg = "ERROR, CLAVE O CONTRASEÑA NO COINCIDEN CON EL FORMATO SOLICITADO";
    header("Location: ../../index.php?msg=$msg");

    exit();
}

*/
//Comparacion para ver si existe ese usuario en la base de datos


//Verifica que usuario y contraseña sean correctos en BD
//checkUsuario
$usuario = conexion();
$stmt = $usuario->prepare("SELECT * FROM users WHERE Nombre = :usuarios");
$stmt->bindParam(':usuarios', $usuarios, PDO::PARAM_STR);
$stmt->execute();


if ($stmt->rowCount() > 0) {
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);
    $hashFromDB = $userData['Contraseña'];
    echo $hashFromDB. "<br>";
    if ($clave === $hashFromDB ) {

        echo $hashFromDB. "<br>";
        echo $clave;
        $stmt = $usuario->prepare("SELECT * FROM users WHERE Nombre = :usuarios AND Contraseña = :clave");
        $stmt->bindParam(':usuarios', $usuarios, PDO::PARAM_STR);
        $stmt->bindParam(':clave', $clave, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt) {
            if ($stmt->rowCount() == 1) {
                $usuario = $stmt->fetch();

                if ($usuario) {
                    $_SESSION['id'] = $usuario['ID'];
                    $_SESSION['Nombre'] = $usuario['Nombre'];
                    $_SESSION['Apellido'] = $usuario['Apellido'];
                    $_SESSION['Email'] = $usuario['Email'];
                    $_SESSION['Contraseña'] = $usuario['Contraseña'];

                    $queryParams = http_build_query([
                        'vista' => 'home',
                        'usr' => $_SESSION['Nombre'],
                        'ape' => $_SESSION['Apellido'],
                        'email' => $_SESSION['Email'],
                        'pass' => $_SESSION['Contraseña']
                    ]);

                    echo "Antes de la redirección...";
                    if (headers_sent()) {
                        echo "<script> window.location.href='../../index.php?vista=home'; </script>";
                    } else {
                        header("Location: ../../index.php?vista=home&$queryParams");

                    }
                }
            } else {
                $msg = "ERROR, CLAVE O CONTRASEÑA INCORRECTOS";
                 header("Location: ../../index.php?msg=$msg");
                exit; // Es importante salir del script después de hacer una redirección
            }
        } else {
            $msg = "Ha ocurrido un error inesperado";
            header("Location: ../../index.php?msg=$msg");
            exit; // Es importante salir del script después de hacer una redirección
        }
    }else {
        $msg = "ERROR, CLAVE O CONTRASEÑA INCORRECTOS";
         header("Location: ../../index.php?msg=$msg");
        exit;
    }

} else {
    $msg = "ERROR, CLAVE O CONTRASEÑA INCORRECTOS";
     header("Location: ../../index.php?msg=$msg");
    exit; 
}

$usuario = null;