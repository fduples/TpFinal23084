<nav class="navbar navbar-expand-lg bg-body-secondary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon">FD</span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../index.php">Inicio</a>
        </li>
        <?php
        if (isset($_SESSION['permiso']) && $_SESSION['permiso'] === "paciente") { ?>        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Mi Perfil
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="perfil.php">Editar Perfil</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="adminPaciente.php">Mis Turnos</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Pedir Turno</a></li>
          </ul>
        </li>
        <li class="nav-item">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#contraseña">Cambiar Contraseña <i class="bi bi-incognito"></i></button>
        </li>
        <?php } ?>
      </ul>      
        <div class="d-flex"  >
        <?php if (!isset($_SESSION['loggedin'])){ ?>
            <div class="navbar-nav">
                <a class="nav-link" href="acceso.php">Ingresar</a>
            </div>
            <div class="navbar-nav">
                <a class="nav-link" href="registro.php" >Registrarse</a>
            </div>
            <?php } else { ?>
              <form class="mt-1">
                <p class="me-2 mt-2"><?php echo $_SESSION['email']; ?></button>
                <button class="btn btn-sm btn-outline-danger align-middle" type="button" onclick="window.location.href = '../controladores/desloggControl.php?salir'" ><i class="bi bi-door-open-fill"></i> Salir</button>
              </form>

                <?php } ?> 
        </div>
    
    </div>
  </div>
</nav>

<!-- Modal -->
<div class="modal fade" id="contraseña" tabindex="-1" aria-labelledby="contraseñaModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title fs-5" id="contraseñaModalLabel">Formulario de modificacion de contrseña</h3>
        <form action="pacienteControl.php?contraseña" method="POST">
          <div class="mb-3">
            <label for="actual" class="col-form-label">Ingrese su contraseña actual:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Recipient:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
          <div class="mb-3">
            <label for="message-text" class="col-form-label">Message:</label>
            <textarea class="form-control" id="message-text"></textarea>
          </div>
        </form>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<script>
  const myModal = document.getElementById('contraseña')
  const myInput = document.getElementById('myInput')

  myModal.addEventListener('shown.bs.modal', () => {
    myInput.focus()
  })
</script>