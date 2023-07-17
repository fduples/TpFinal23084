<nav class="navbar navbar-expand-lg bg-body-secondary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon">FD</span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Inicio</a>
        </li>
        <?php if (isset($_SESSION['permiso']) && $_SESSION['permiso'] === "administrador") { ?>        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Administración
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="admin.php">Usuarios</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="adminPaciente.php">Pacientes</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Médicos</a></li>
          </ul>
        </li>
        <?php } 
        if (isset($_SESSION['permiso']) && $_SESSION['permiso'] === "paciente") { ?>        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Mi Perfil
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="pacientes/perfil.php">Editar Perfil</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="adminPaciente.php">Mis Turnos</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Pedir Turno</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="index.php">Cambiar Contraseña <i class="bi bi-incognito"></i></a>
        </li>
        <?php } 
        if (isset($_SESSION['permiso']) && $_SESSION['permiso'] === "medico") { ?>        
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Administrar Consulta
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="admin.php">Turnos a atender</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="adminPaciente.php"></a>Especialidades</li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Pedir Turno</a></li>
            </ul>
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