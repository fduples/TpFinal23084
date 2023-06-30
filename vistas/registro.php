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
  <title>Registro de Usuario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
<?php include('recursos/barra.php'); ?>
        <h3 class="text-center my-4" id="titulo">Registro Usuario</h3>

    <div class="container bg-light text-center d-flex justify-content-center p-3 border w-25">
      <div class="w-75">
        <form action="../controladores/UsuarioControl.php?reg" method="post">
          <div class="form-group mb-3">
            <label for="usuario" class="form-label fs-5">Usuario:</label>
            <input type="email" onkeyup="validarUsu()" name="usuario" id="usuario" class="form-control" placeholder="Usuario" required>
            <div id="mensajeUsu"></div>
          </div>
          <div class="form-group mb-3">
            <label for="clave" class="form-label fs-5">Contraseña:</label>
            <input type="password" onkeyup="defFortaleza()" name="clave" id="clave" class="form-control" placeholder="Contraseña" required>
            <div id="mensajePass"></div>
          </div>
          <div class="form-group mb-3">
            <label for="repPass" class="form-label fs-5">Reingrese Contraseña:</label>
            <input type="password" onkeyup="compararPass()" name="repPass" id="repPass" class="form-control" placeholder="Reingrese Contraseña" required>
            <div id="mensajeCompara"></div>
          </div>
          <div class="form-check w-50 mx-auto mb-3">
            <input class="form-check-input fs-4" type="checkbox" name="checkAdmin" id="checkAdmin" value="option1">
            <label class="form-check-label fs-5" for="checkAdmin">
              Es Administrador
            </label>
          </div>
          <div class="form-group mb-3">
            <label for="claveAdmin" class="form-label fs-5">Contraseña:</label>
            <input type="hidden" name="claveAdmin" id="claveAdmin" class="form-control" placeholder="Token Administrador">
            <div id="mensajeAdmin"></div>
          </div>
          <input type="submit" value="Registrar" class="btn btn-primary disabled d-flex" id="enviar">
        </form>
        </div>
        <?php 
        if (isset($_GET['existe'])) {
        ?>
        <div class="alert alert-warning m-3 text-danger fw-bold" role="alert">
          La dirección de correo <?php echo $_GET['existe']; ?> ha sido registrado anterioriormente
        </div>
        <?php
        }
        ?>
    </div>

  <script src="js/usuario.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>

