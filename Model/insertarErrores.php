<?php
include_once "../Controller/conect.php";

$BASEDATOS = "errores";
$usarbaseDatos = "USE $BASEDATOS";
$conexionBD = mysqli_query($sqlCreacion, $usarbaseDatos );
 
//echo "FUNCIONA";
//echo $error_message;
if ($conexionBD) {
$sql = "INSERT INTO `errores`(`texto_errores`) VALUES ('$error_message')";
$inserion = mysqli_query($sqlCreacion, $sql);
if ($inserion) {
    echo "ERRRORES BIEN INGRESADOS";
}else{
    echo "NO FUNCIONA";
}}

?>

