<?php
include "Controller/conect.php";
require "Views/php/session_start.php"; ?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="Views/bootstrap-5.3.1-dist/css/bootstrap.min.css">
    <script src="Views/bootstrap-5.3.1-dist/js/bootstrap.min.js"></script>
    <?php require "Views/php/head.php"; ?>
</head>

<body>
    <?php

if (isset($_GET["msg"])) {
    $msg = $_GET["msg"];
  }

    if (!isset($_GET['vista']) || $_GET['vista'] == "") {
        $_GET['vista'] = "login";
    }

    if (is_file("Views/vistas/" . $_GET['vista'] . ".php") && $_GET['vista'] != "login" && $_GET['vista'] != "404") {

        /*== Cerrar sesion ==*/
        session_unset();
     
        include "Views/vistas/" . $_GET['vista'] . ".php";
        

    } else {
        if ($_GET['vista'] == "login") {
            include "Views/vistas/login.php";
        } else {
            include "Views/vistas/404.php";
        }
    }
    ?>
</body>


</html>