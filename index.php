<?php
require_once "config.php";
/*session_start();
var_dump($_SESSION);
var_dump($_SESSION);
print_r($_SESSION);
*/
//Verifico que exista una session activa.
if (!isset($_SESSION['loggedin'])) {
    // Redirjo al formulario de inicio de sesión si no hay session activa
    header("Location: vistas/acceso.php");
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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TP Final 23084</title>
</head>
<body>
    
</body>
</html>