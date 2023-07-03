<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['loggedin'])) {
    // Redirigir al formulario de inicio de sesión
    header("Location: acceso.php");
    exit;
}

// Verificar si el usuario es un superusuario
//$permiso_usu = $_SESSION['permiso'];
if ($_SESSION['permiso'] !== 'administrador') {
    // Mostrar mensaje de acceso denegado
    echo 'Acceso denegado. No tienes los permisos necesarios para acceder a esta página.';
    header("Location: index.php?sinPermiso");
    exit;
}




// Cargar el modelo de Asistencia
require_once '../modelos/UsuarioModel.php';

$usuMod = new UsuarioModel();

// Obtener la lista de usuarios
$usuarios = $usuMod->obtenerUsuarios();
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
    
        <h1>Usuarios</h1>
        <?php if (isset($mensaje)): ?>
            <div class="alert alert-success"><?php echo $mensaje; ?></div>
        <?php endif; ?>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo electrónico</th>
                    <th>Permiso</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?php echo $usuario['id']; ?></td>
                        <td><?php echo $usuario['nombre_usu']; ?></td>
                        <td><?php echo $usuario['correo_usu']; ?></td>
                        <td><?php echo $usuario['permiso_usu']; ?></td>
                        <td>
                        <!--   <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#borrarUsu" onclick="window.location.href = '../controladores/desloggControl.php?salir'"><i class="bi bi-person-x"></i></button>
                         <a href="editar_usuario.php?id=<?php echo $usuario['id']; ?>">Editar</a> 
                            <button href="usuarioControl.php?borraid=<?php echo $usuario['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar este usuario?')" class="btn btn-outline-danger"><i class="bi bi-person-x"></i></button>-->
                            <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmModal" data-id="<?php echo $usuario['id']; ?>"><i class="bi bi-person-x"></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#borrarUsu">
             Agregar Usuario Nuevo
        </button>
        
        <p><a href="admin.php">Volver al área de administración</a></p>
    </div>

    <!-- MODAL CONFIRMACIÓN ELIMINAR USUARIO -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmModalLabel">Confirmación de eliminación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Estás seguro de eliminar este usuario?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <a id="deleteUserLink" href="" class="btn btn-danger">Eliminar</a>
      </div>
    </div>
  </div>
</div>
<!-- FIN MODAL CONFIRMACIOón -->
    <div class="modal fade" id="borrarUsu" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="borrarUsuLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="borrarUsuLabel">Editar Usuario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form action="controladores/agregaUsuarioControl.php?nuevo" method="POST">
                <div class="form-group">
                    <label for="nombre_usu">Nombre:</label>
                    <input type="text" class="form-control" name="nombre_usu" required="required">
                </div>
                <div class="form-group">
                    <label for="correo_usu">Correo electrónico:</label>
                    <input type="email" class="form-control" name="correo_usu" required="required">
                </div>
                <div class="form-group">
                    <label for="clave_usu">Contraseña:</label>
                    <input type="password" class="form-control" name="clave_usu" required="required">
                </div>
                <div class="form-group">
                    <label for="permiso_usu">Permiso:</label>
                    <select class="form-control" name="permiso_usu" required="required">
                        <option value="normal">Normal</option>
                        <option value="superusuario">Superusuario</option>
                    </select>
                </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
    </div>
    <!-- Button trigger modal -->
<button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#borrarUsu">
<i class="bi bi-person-x"></i>
</button>

<!-- Modal -->
<div class="modal fade" id="borrarUsu" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="borrarUsuLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="borrarUsuLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div>
    </div>
  </div>
</div>

<script>
        // Obtener el botón de eliminación y el enlace correspondientes
        var deleteButton = document.querySelector('#confirmModal button.btn-danger');
        var deleteUserLink = document.querySelector('#deleteUserLink');

        // Asignar el evento click al botón de eliminación
        deleteButton.addEventListener('click', function() {
            var userId = this.getAttribute('data-id');
            deleteUserLink.href = window.location.href = '../controladores/usuarioControl.php?borrar_id='.userId;
        });
    </script>
    <script>
        const myModal = document.getElementById('myModal')
        const myInput = document.getElementById('myInput')

        myModal.addEventListener('shown.bs.modal', () => {
        myInput.focus()
        })
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>