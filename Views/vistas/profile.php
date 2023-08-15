<?php
include "Views/php/navbar.php";


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

?>

<div class="title">

  <h1 class="title-home">Hola
    <?php echo $usuario . " " . $usuarioApe; ?>!
  </h1>
  <h2 class="title-home">¿Desea cambiar sus datos?</h2>
</div>

<h1 class="text-form">Rellene los datos que desea cambiar</h1>

<div class="container-form">
  <form action="Controller/updateUser.php?email=<?php echo $email ;?>&pass=<?php echo $pass ;?>" method="POST" >
    <div class="form-row">
      <div class="form-column">
        <label for="name">Nombre:</label>
        <input type="text" name="newName" id="name" placeholder="Nombre" class="text-input">
      </div>
      <div class="form-column">
        <label for="last">Apellido:</label>
        <input type="text" name="NewlastName" id="last" placeholder="Apellido" class="text-input">
      </div>
    </div>
    <div class="form-row">
      <div class="form-column">
        <label for="email">Email:</label>
        <input type="email" name="Newemail" id="email" placeholder="Email" class="text-input">
      </div>
      <div class="form-column">
        <label for="password">Contraseña:</label>
        <input type="password" name="Newpassword" id="password" placeholder="Contraseña" class="text-input">
      </div>
    </div>
    <div class="botones">
    <button type="submit" id="sent">Enviar</button>
    <button type="reset" id="sent" > Borrar datos</button>
    </div>
  </form>
</div>


<div class="new">
  <a href="index.php?vista=newUser&usr=<?php echo $usuario ?>&ape=<?php echo $usuarioApe ?>&email=<?php echo $email?>&pass=<?php echo $pass?>" id ="sent">Añadir un nuevo usuario</a>
</div>