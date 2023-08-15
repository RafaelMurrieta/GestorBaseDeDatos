<?php
session_start();

// Si la sesión existe, la destruimos para cerrar la sesión del usuario
if (isset($_SESSION['Email'])) {
    // Destruir completamente la sesión
    session_destroy();
    // Redirigir al usuario a la página de inicio o a otra página de tu elección
    header("Location: ../../index.php");
    exit(); // Es importante hacer exit() después de la redirección para evitar problemas
}else{
	?>
	
	<script>
	alert("No hay sesion inciada");
</script>
<?php
header("Location: ../../index.php");
	}

?>
