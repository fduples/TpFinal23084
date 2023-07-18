<?php
require_once "PacienteModel.php";
session_start();
//Verifico que exista una session activa.
if (!isset($_SESSION['loggedin'])) {
    // Redirjo al formulario de inicio de sesión si no hay session activa
    header("Location: ../acceso.php");
    exit;
}

// Guardo el tiempo de última actividad del usuario almacenado en la sesión
$ultima_actividad = isset($_SESSION['ultima_actividad']) ? $_SESSION['ultima_actividad'] : time();

// Verifico si pasó el tiempo de inactividad establecido y si pasó destruyo la session
if ((time() - $ultima_actividad) > TIEMPO_INACTIVIDAD) {
    // Destruyo la sesión y redirij al formulario de acceso para volver a loggear usuario
    session_destroy();
    header("Location: ../acceso.php");
    exit;
}

// Como la session aun esta activa actualizo la última actividad con el tiempo actual
$_SESSION['ultima_actividad'] = time();
$modelo = new PacienteModel();
$paciente = $modelo->obtenerPacienteUsuario($_SESSION['id_usu']);

?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edición Perfil <?php echo $paciente['nombre_usu']; ?></title>
    <link rel="stylesheet" href="css/estilo.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="recursos/img/command.svg" type="image/x-icon">

  </head>
  <body>
  <?php include("barra_paciente.php"); ?>  
    
    <h1 class="text-center">PERFIL <?php echo $paciente['nombre_usu'];?></h1>
    <div class="container bg-body-secondary text-center d-flex justify-content-center p-3 border w-50 mb-3">
        
      <div class="w-75">
        <form action="pacienteControl.php?edita" method="post">
            <div class="form-group" class="form-label fs-5">
                <label for="nombre">Nombre y Apellido:</label>
                <input type="text" class="form-control shadow" id="nombre" name="nombre" placeholder="Nombre y Apellido" required value="<?php echo $paciente['nombre_usu'];?>">
            </div>
            <div class="form-group mb-3">
                <label for="documento" class="form-label fs-5">Documento:</label>
                <input type="number" class="form-control shadow" id="documento" name="documento" required value="<?php echo $paciente['documento'];?>">
            </div>
            <div class="form-group mb-3">
                <label for="usuario" class="form-label fs-5">Ingrese su correo electrónico:</label>
                <input type="email" onkeyup="validarUsu()" name="usuario" id="usuario" class="form-control shadow" placeholder="Usuario" required value="<?php echo $paciente['correo_usu'];?>">
            <div id="mensajeUsu"></div>
            <div class="form-group mb-3">
                    <label for="telefono" class="form-label fs-5">Teléfono:</label>
                    <input type="text" class="form-control shadow" id="telefono" name="telefono" required value="<?php echo $paciente['telefono'];?>">
                </div>
            </div>
          <input type="hidden" name="permiso" id="permiso" value="paciente">
          <input type="hidden" name="idEdita" id="idEdita" value="<?php echo $paciente['id_usu']; ?>">
          <div class="w-100">
            <a class="btn btn-info" href="../index.php">Cancelar</a>
            <input type="submit" value="Guardar" class="btn btn-success" id="enviar">
          </div>
        </form>
        </div>
        </div>
    </div>

  </div>
    <script src="../js/usuario.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</html>