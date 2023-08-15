<?php
require "conect.php";
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

<body>
    <div class="union">
    <form action="Controller/crearbd.php" method="POST" id="container">
        <input type="hidden" value="<?php echo $usuario; ?>" name="usr">
        <input type="hidden" value="<?php echo $usuarioApe; ?>" name="ape">
        <input type="hidden" value="<?php echo $email; ?>" name="email">
        <input type="hidden" value="<?php echo $pass; ?>" name="pass">
        <h3>¿Quieres crear una base de datos?</h3>
        <input type="text" name="nameBD" placeholder="Nombre de la Base de Datos" id="estilosName">
        <button type="submit" value="Enviar" id="embiar">Crear base de datos</button>
    </form>

    <h5 class="elements">Aqui se encuentran todas las bases de datos creadas</h5>
    <div class="elements">
  
    <?php

$sqlBd = "SHOW DATABASES";
if ($result = mysqli_query($sqlCreacion, $sqlBd)) {
    echo '<table class="tablaBaseDeDatos">';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>';
        echo '<div class="dataBase">';
        echo "<a id='basesDeDatos'>";
        $bd = $row['Database'];
        echo "<a value='" . htmlspecialchars(stripslashes($row['Database'])) . "'><a href='index.php?vista=BD&bd=$bd&usr=$usuario&ape=$usuarioApe&email=$email&pass=$pass'>" . htmlspecialchars(stripslashes($row['Database'])) . "</a></a>";
        echo "</a>";
        echo "</div>";
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';
}
?>

    </div>
    </div>

    
</body>