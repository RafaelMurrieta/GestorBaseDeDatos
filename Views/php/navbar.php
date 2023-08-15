<?php
if (isset($_GET['vista'])) {
    $vista = $_GET['vista'];
}


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
<div class="container-nav">
    <link rel="stylesheet" href="../Views/css/home-index.css">

    <a href="index.php?vista=home&usr=<?php echo $usuario ?>&ape=<?php echo $usuarioApe ?>&email=<?php echo $email ?>&pass=<?php echo $pass ?>"
        class="logo-home"><img src="Controller/img/letra-m.png" alt=""></a>

        <div id="perfil">
        <?php if ($vista !== 'home' && $vista !== '') { ?>
        <a href="index.php?vista=home&usr=<?php echo $usuario ?>&ape=<?php echo $usuarioApe ?>&email=<?php echo $email ?>&pass=<?php echo $pass ?>" id="log" onclick="btnReturn()">Regresar </a>
        <?php } ?>
    </div>

    <a href="index.php?vista=profile&usr=<?php echo $usuario ?>&ape=<?php echo $usuarioApe ?>&email=<?php echo $email ?>&pass=<?php echo $pass ?>"
        id="profile"><img src="Controller/img/perfil.png" alt=""></a>
    <a href="Views/vistas/logout.php" id="logout">salir</a>
</div>