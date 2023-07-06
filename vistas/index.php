<?php
require_once "../config.php";
session_start();
//Verifico que exista una session activa.
if (!isset($_SESSION['loggedin'])) {
    // Redirjo al formulario de inicio de sesión si no hay session activa
    header("Location: acceso.php");
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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Codo a Codo #23084 - Federico Duples</title>
    <link rel="stylesheet" href="css/estilo.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="recursos/img/command.svg" type="image/x-icon">

  </head>
  <body>
  <?php include("recursos/barra.php"); ?>  
    
  <div class="container mt-5">
    <h1>Trabajo Práctico Final - Codo a Codo 2023</h1>
    <div>
      <p>Autor: Federico Duples</p>
    </div>
    <div>
      <p>Comisión: 23.084</p>
    </div>
    <div class="card">
      <div class="card-body">
        <h3>Tecnologías utilizadas:</h3>
        <div>
          <p>Se intentó reflejar algunas de las herramientas aprendidas durante la cursada como:</p>
        </div>
        <ul>
          <li>HTML</li>
          <li>CSS</li>
          <li>Bootstrap</li>
          <li>PHP - POO - MVC</li>
          <li>MySQL</li>
        </ul>
        <div>
          <p>También se intentaron implementar otras tecnologías que fueron aprendidas por cuenta propia: </p>
          <p>El sistema de loggin se complementó con la utilización de sesiones de PHP</p>
        </div>
      </div>
    </div>
  </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</html>