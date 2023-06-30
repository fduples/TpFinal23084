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
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <!-- Dropdown para usar mas adelante
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li> -->
        
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
                <p><?php echo $_SESSION['email']; ?></p>
                <button class="btn btn-danger" onclick="window.location.href = '../controladores/desloggControl.php?salir'" >Salir</button>

                <?php } ?> 
        </div>
    
    </div>
  </div>
</nav>