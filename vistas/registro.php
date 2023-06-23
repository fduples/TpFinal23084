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
        <h3 class="text-center my-4" id="titulo">Registro Usuario</h3>

    <div class="container bg-light text-center d-flex justify-content-center p-3 border w-25">
      <div class="w-75">
        <form action="../controladores/UsuarioControl.php?reg" method="post">
          <div class="form-group mb-3">
            <label for="usuario" class="form-label">Usuario:</label>
            <input type="email" onkeyup="validarUsu()" name="usuario" id="usuario" class="form-control" placeholder="Usuario" required>
            <div id="mensajeUsu"></div>
          </div>
          <div class="form-group mb-3">
            <label for="clave" class="form-label">Contraseña:</label>
            <input type="password" onkeyup="defFortaleza()" name="clave" id="clave" class="form-control" placeholder="Contraseña" required>
            <div id="mensajePass"></div>
          </div>
          <div class="form-group mb-3">
            <label for="repPass" class="form-label">Reingrese Contraseña:</label>
            <input type="password" onkeyup="compararPass()" name="repPass" id="repPass" class="form-control" placeholder="Reingrese Contraseña" required>
            <div id="mensajeCompara"></div>
          </div>
          <input type="submit" value="Registrar" class="btn btn-primary disabled" id="enviar">
        </form>
        </div>
        <?php 
        if (isset($_GET['existe'])) {
        ?>
        <div class="alert alert-warning m-3 text-danger fw-bold" role="alert">
          La dirección de orreo <?php echo $_GET['existe']; ?> ha sido registrado anterioriormente
        </div>
        <?php
        }
        ?>
    </div>

  <script src="js/usuario.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>

