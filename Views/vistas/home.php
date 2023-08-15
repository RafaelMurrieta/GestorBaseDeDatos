<?php

if (isset($_GET['usr'])) {
    $usuario['Nombre'] = $_GET['usr'];
}
if (isset($_GET['ape'])) {
    $usuario['Apellido'] = $_GET['ape'];
}
if (isset($_GET['email'])) {
    $usuario['Email'] = $_GET['email'];
}

if (isset($_GET['pass'])) {
  $usuario['pass'] = $_GET['pass'];
}

// Puedes acceder a los datos recibidos en $usuario
// Por ejemplo:
if (isset($usuario['Nombre'])) {
    $nombreUsuario = $usuario['Nombre'];
    // Realiza acciones con el nombre del usuario...
}
if (isset($usuario['Apellido'])) {
    $apellidoUsuario = $usuario['Apellido'];
    // Realiza acciones con el apellido del usuario...
}
if (isset($usuario['Email'])) {
    $emailUsuario = $usuario['Email'];
    // Realiza acciones con el correo electrónico del usuario...
}
if (isset($usuario['pass'])) {
  $passUsuario = $usuario['pass'];
  // Realiza acciones con el correo electrónico del usuario...
}





if (isset($_GET["msg"])) {
  $msg = $_GET["msg"];
  ?>
  <script>
    alert("<?= $msg; ?>");
  </script>

  <?php
}

include "Views/php/navbar.php";
?>
<div class="title">

  <h1 class="title-home">Hola
    <?php echo $usuario . " " . $usuarioApe; ?>!
  </h1>
  <h1 class="title-home">¡Bienvenido a MURRY!</h1>


</div>
<div class="dataBase">

  <?php
  if (!isset($_GET['vistaHome']) || $_GET['vistaHome'] == "") {
    $_GET['vistaHome'] = "viewBd";

  }
  include "Controller/" . $_GET['vistaHome'] . ".php";
  ?>
</div>

</body>

</html>