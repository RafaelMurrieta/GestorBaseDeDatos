<?php
if (isset($_GET["msg"])) {
    $msg = $_GET["msg"];
    ?>
    <script>
        alert("<?= $msg; ?>");
    </script>

    <?php
}

?>

<body>

    <header>
        <a href="index.php" class="logo"><img src="Controller/img/letra-m.png" alt=""></a>
    </header>
    <div class="index-container">

        <form class="form" action="Views/php/start_session.php" method="POST" autocomplete="off">
            <h1 class="form-title">Bienvenido</h1>
            <div class="card-form">
                <label class="label">Usuario: </label>
                <div class="control">
                    <input class="input-text" type="text" name="usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20"
                        required>
                </div>
            </div>

            <div class="card-form">
                <label class="label">Contraseña: </label>
                <div class="control">
                    <input class="input-text" type="password" name="clave" pattern="[a-zA-Z0-9$@.-]{7,100}"
                        maxlength="18" required>
                </div>
            </div>

            <div>
                <!-- CAPTCHA-->
                <div class="card-form">
                    <div class="g-recaptcha" data-sitekey="6LdQj4wnAAAAAIIgCl9a6IVdT2fKnz4jeNUllweG"></div>
                </div>

            </div>

            <a href="Views/vistas/forgetPass.php" class="forget">¿Olvidaste tu contraseña?</a>
            <p>
                <button type="submit" class="form-loguear">Iniciar sesion</button>
            </p>

            <?php
            if (isset($_POST['usuario']) && isset($_POST['clave'])) {
                require_once "Views/php/valitation.php";
                require_once "Views/php/start_session.php";

            }
            ?>

        </form>
    </div>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>

</html>