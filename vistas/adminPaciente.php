<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['loggedin'])) {
    // Redirigir al formulario de inicio de sesión
    header("Location: acceso.php");
    exit;
}

// Verificar si el usuario es un superusuario
if ($_SESSION['permiso'] !== 'administrador') {
    // Mostrar mensaje de acceso denegado
    echo 'Acceso denegado. No tienes los permisos necesarios para acceder a esta página.';
    header("Location: index.php?sinPermiso");
    exit;
}

// Cargar el modelo PacienteUsuarioModel
require_once '../modelos/PacienteModel.php';

$modelo = new PacienteModel();

// Obtener la lista de pacientes y usuarios
$pacientesUsuarios = $modelo->obtenerPacientesUsuarios();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración Usuarios</title>
    <link rel="stylesheet" href="css/estilo.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="recursos/img/ticket-perforated-fill.svg" type="image/x-icon">
</head>
<body>
<?php include("recursos/barra.php"); ?> 
    <div class="container">
    <?php 
        if (isset($_GET['borrado'])) {
        ?>
        <div class="alert alert-warning m-3 mx-auto text-danger fw-bold container-fluid" role="alert">
          El usuario ha sido borrado!
        </div>
        <?php
        }
        ?>
        <h1>Usuarios</h1>
        <?php if (isset($mensaje)): ?>
            <div class="alert alert-success"><?php echo $mensaje; ?></div>
        <?php endif; ?>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Documento</th>
                    <th>Correo electrónico</th>
                    <th>Teléfono</th>
                    <th>Permiso</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pacientesUsuarios as $pacienteUsuario): ?>
                    <tr>
                        <td><?php echo $pacienteUsuario['id']; ?></td>
                        <td><?php echo $pacienteUsuario['nombre']; ?></td>
                        <td><?php echo $pacienteUsuario['documento']; ?></td>
                        <td><?php echo $pacienteUsuario['correo']; ?></td>
                        <td><?php echo $pacienteUsuario['telefono']; ?></td>
                        <td><?php echo $pacienteUsuario['permiso']; ?></td>
                        <td>
                            <button class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editaModal" onClick="edicion(<?php echo $pacienteUsuario['id']; ?>, '<?php echo $pacienteUsuario['nombre']; ?>', '<?php echo $pacienteUsuario['documento']; ?>', '<?php echo $pacienteUsuario['correo']; ?>', '<?php echo $pacienteUsuario['telefono']; ?>', '<?php echo $pacienteUsuario['permiso']; ?>')"><i class="bi bi-pencil-square"></i></button>
                            <button type="button" class="btn btn-outline-danger" onClick="confirmaEliminar(<?php echo $pacienteUsuario['id']; ?>)"><i class="bi bi-person-x"></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>        
        <a class="btn btn-primary" href="index.php">Volver al inicio</a>
    </div>
<!-- MODAL EDICIÓN USUARIO -->
<div class="modal fade" id="editaModal" tabindex="-1" aria-labelledby="editaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editaModalLabel">Interfaz de edición de usuarios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../controladores/pacienteControl.php?edita" method="post">
                    <div class="form-group" class="form-label fs-5">
                        <label for="nombre">Nombre y Apellido:</label>
                        <input type="text" class="form-control shadow" id="nombre" name="nombre" placeholder="Nombre y Apellido" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="documento" class="form-label fs-5">Documento:</label>
                        <input type="text" class="form-control shadow" id="documento" name="documento" placeholder="Documento" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="telefono" class="form-label fs-5">Teléfono:</label>
                        <input type="text" class="form-control shadow" id="telefono" name="telefono" placeholder="Teléfono" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="usuario" class="form-label fs-5">Ingrese su correo electrónico:</label>
                        <input type="email" onkeyup="validarUsu()" name="usuario" id="usuario" class="form-control shadow" placeholder="Usuario" required>
                        <div id="mensajeUsu"></div>
                    </div>
                    <div class="form-check mb-3 rounded-2 p-3 text-danger fw-bold">
                        <input class="form-check-input mx-auto my-auto border border-black me-2" type="checkbox" name="checkAdminEdita" id="checkAdminEdita">
                        <label class="form-check-label" for="checkAdminEdita">Es Administrador</label>
                    </div>

                    <input type="hidden" name="permisoEdita" id="permisoEdita" value="noAdmin">
                    <input type="hidden" name="idEdita" id="idEdita" value="">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <input type="submit" value="Guardar" class="btn btn-primary d-flex" id="enviar">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- FIN MODAL EDICIÓN -->


    <script src="js/usuario.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
