<?php
if (isset($_GET["msg"])) {
    $msg = $_GET["msg"];
    ?>
    <script>
        alert("<?=$msg;?>");
    </script>

    <?php
}
?>
<link rel="stylesheet" href="../css/index.css">

<body>

    <header>
        <a href="../../index.php" class="logo"><img src="../../Controller/img/letra-m.png" alt=""></a>
    </header>
    <div class="index-container">

        <form class="form" action="Views/php/start_session.php" method="POST" autocomplete="off">
            <h1 class="form-title">¿Olvidaste tu contraseña?</h1>
            <h2 class="form-title">LLena este formulario</h2>
            <div class="card-form">
                <label class="label">Correo electronico: </label>
                <div class="control">
                    <input class="input-text" type="text" name="usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20"
                        required>
                </div>
            </div>

            <div class="card-form">
                <label class="label">Nueva contraseña:</label>
                <div class="control">
                    <input class="input-text" type="password" name="clave" pattern="[a-zA-Z0-9$@.-]{7,100}"
                        maxlength="18" required>
                </div>
            </div>
            <p>
                <button type="submit" class="form-loguear-pass">Actualizar contraseña</button>
            </p>
        </form>
    </div>
</body>

</html>