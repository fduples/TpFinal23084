<?php
require_once "../config.php";
session_start();

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

//Verifico que exista una session activa.
if (isset($_SESSION['loggedin'])) {
  // Redirjo al al index porque ya hay una session logueada
  header("Location: index.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pagina de acceso de Usuario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
  <?php include('recursos/barra.php'); ?>
        <h3 class="text-center my-4" id="titulo">Ingreso Usuario</h3>

    <div class="container bg-light text-center d-flex justify-content-center p-3 border w-25">
      <div class="w-75">
        <form action="../controladores/UsuarioControl.php" method="post">
          <div class="form-group mb-3">
            <label for="usuario" class="form-label">Correo:</label>
            <input type="email" name="usuario" id="usuario" class="form-control" placeholder="Usuario" required>
          </div>
          <div class="form-group mb-3">
            <label for="clave" class="form-label">Contraseña:</label>
            <input type="password" name="clave" id="clave" class="form-control" placeholder="Contraseña" required>
          </div>
          
          <input type="submit" value="Ingresar" class="btn btn-primary" id="enviar">
        </form>
        </div>
    </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>