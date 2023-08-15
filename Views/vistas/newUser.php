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
if (isset($_GET["mgs"])) {
    $msg= $_GET["msg"];
    


}

?>
<div class="title">
<h1 class="title-home">Hola
  <?php echo $usuario . " " . $usuarioApe; ?>!
</h1>
<h1 class="title-home">¿Quiere agregar un nuevo usuario?</h1>
</div>

<div class="container-form" id="newusr" >
  <form action="Controller/createNewUser.php?usr=<?php echo $usuario ?>&pass=<?php echo $usuarioApe ?>&email=<?php echo $email?>&pass=<?php echo $pass?>" method="POST" >
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


    <div class="botones2">
    <button type="submit" id="sent">Crear el nuevo usuario</button>
    <button type="reset" id="sent" > Borrar datos</button>
    </div>
  </form>
</div>