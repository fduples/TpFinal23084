<?php
session_start();
//###### Cierre manual de sesion ######//
if (isset($_GET['salir'])) {
    session_destroy();
    header("Location: ../vistas/acceso.php");
    exit;
}
//###### Cierre manual de sesion ######//
?>