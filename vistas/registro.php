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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="css/estilo.css">
  <link rel="shortcut icon" href="recursos/img/command.svg" type="image/x-icon">
</head>
<body>
<?php include('recursos/barra.php'); ?>
        <h3 class="text-center my-4" id="titulo">Registro Usuario</h3>

    <div class="container bg-body-secondary text-center d-flex justify-content-center p-3 border w-25">
      
      <div class="w-75">
      <?php 
        if (isset($_GET['existe'])) {
        ?>
        <div class="alert alert-warning m-3 mx-auto text-danger fw-bold container-fluid" role="alert">
          La dirección de correo <?php echo $_GET['existe']; ?> ha sido registrado anterioriormente
        </div>
        <?php
        }
        ?>
        <form action="../controladores/UsuarioControl.php?reg" method="post">
          <div class="form-group" class="form-label fs-5">
            <label for="nombre">Nombre y Apellido:</label>
            <input type="text" class="form-control shadow" id="nombre" name="nombre" placeholder="Nombre y Aepeliido" required>
          </div>
          <div class="form-group mb-3">
            <label for="documento" class="form-label fs-5">Documento:</label>
            <input type="number" class="form-control shadow" id="documento" name="documento" required>
          </div>
          <div class="form-group mb-3">
            <label for="usuario" class="form-label fs-5">Ingrese su correo electrónico:</label>
            <input type="email" onkeyup="validarUsu()" name="usuario" id="usuario" class="form-control shadow" placeholder="Usuario" required>
          <div id="mensajeUsu"></div>
          <div class="form-group mb-3">
                <label for="telefono" class="form-label fs-5">Teléfono:</label>
                <input type="text" class="form-control shadow" id="telefono" name="telefono" required>
            </div>
          </div>
          <div class="form-group mb-3">
            <label for="clave" class="form-label fs-5">Contraseña:</label>
            <input type="password" onkeyup="defFortaleza()" name="clave" id="clave" class="form-control  shadow" placeholder="Contraseña" required>
            <div id="mensajePass"></div>
          </div>
          <div class="form-group mb-3">
            <label for="repPass" class="form-label fs-5">Reingrese Contraseña:</label>
            <input type="password" onkeyup="compararPass()" name="repPass" id="repPass" class="form-control" placeholder="Reingrese Contraseña" required>
            <div id="mensajeCompara"></div>
          </div>
          <div class="form-check mb-3 rounded-2 p-3">
            <input class="form-check-input mx-auto my-auto border border-black" type="checkbox" name="checkAdmin" id="checkAdmin" value="option1" onchange="mostrarCajaAdmin()">
            <label class="form-check-label" for="checkAdmin">Es Administrador</label>
          </div>
          <div class="form-group mb-3" id="cajaAdmin" style="display: none;">
            <label for="claveAdmin" class="form-label">Ingrese token de Administrador:</label>
            <input type="password" name="claveAdmin" id="claveAdmin" class="form-control" placeholder="Token Administrador">
            <div id="mensajeAdmin"></div>
          </div>

          <input type="hidden" name="permiso" id="permiso" value="noAdmin">
          <input type="submit" value="Registrar" class="btn btn-primary disabled d-flex" id="enviar">
       
        </form>
        </div>
    </div>

  <script src="js/usuario.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>

