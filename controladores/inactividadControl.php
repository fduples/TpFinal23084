<?php
session_start();

//###### SESSION ######//
//Verifico que exista una session activa.
if (isset($_SESSION['loggedin'])) {
    // Redirjo al index inicio si hay session activa
    header("Location: ../vistas/index.php");
    exit;
}

// Guardo el tiempo de última actividad del usuario almacenado en la sesión
$ultima_actividad = isset($_SESSION['ultima_actividad']) ? $_SESSION['ultima_actividad'] : time();

// Verifico si pasó el tiempo de inactividad establecido y si pasó destruyo la session
if ((time() - $ultima_actividad) > TIEMPO_INACTIVIDAD) {
    // Destruyo la sesión y redirij al formulario de acceso para volver a loggear usuario
    session_destroy();
    header("Location: acceso.php");
    exit;
}

// Como la session aun esta activa actualizo la última actividad con el tiempo actual
$_SESSION['ultima_actividad'] = time();
//###### SESSION ######//

?>