<?php
session_start();
 if(!isset($_SESSION["usuario"]) && $_SESSION["nivel_usuario"] !='admin'){
        $_SESSION = null;
        session_destroy();
        header('Location: /appResto/');
}
?>
<?php
require_once('../Lib/controlMesa.php');
?>

<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Salón</title>
  <link rel="stylesheet" href="./css/estilos.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<body data-bs-theme="dark">

  <div class="container">

    <div class="row">
      <div class="">
        <a href="?" class=" blanco">
          <h1 class="text-center bg-danger border border-danger border-1 rounded-5 rounded-top-0 mt-1 align-midle p-2">Mesas</h1>
        </a>
      </div>
      <?php
      $chunked_mesas = array_chunk($mozo, 4); // dividir las mesas en grupos de 3
      foreach ($chunked_mesas as $grupo_mesas) { // recorrer cada grupo de mesas
      ?>

        <div class="row row-cols-4 g-6 mb-4">

          <?php
          foreach ($grupo_mesas as $mesa) { // recorrer cada mesa dentro del grupo
          ?>
            <div class="col">
              <div class="h-100">
                <?php
                //establecemos los posibles estados de las mesas y segun el estado lo que debe mostrar
                if ($mesa['estado_mesa'] == 23) { ?>
                  <div class="">
                    <div class="contenedor_circulo">
                      <button href="pedido_mesa.php?mesa=<?php echo $mesa['id']; ?>" class="h-100 mesaRedonda" id="<?php echo $mesa['id']; ?>">
                        <img src="img/Mesa_Amarilla.png" alt="mesa amarilla">
                        <p class="numero-mesa"><?php echo $mesa['id']; ?></p>
                      </button>
                    </div>
                    <p class="card-text text-center blanco">Requiere Servicio</p>
                  </div>
                <?php
                } elseif ($mesa['estado_mesa'] == 20) { ?>
                  <div class="">
                    <div class="contenedor_circulo">
                      <button href="#" class="h-100 mesaRedonda" id="<?php echo $mesa['id'] . "-link"; ?>" onclick="alert('Esta mesa está libre, no hay pedidos.')">
                        <img src="img/Mesa_Blanca.png" alt="mesa blanca">
                        <p class="numero-mesa"><?php echo $mesa['id']; ?></p>
                      </button>
                    </div>
                    <p class="card-text text-center blanco">Mesa Libre</p>
                  </div>
                <?php
                } elseif ($mesa['estado_mesa'] == 21) { ?>
                  <div class="">
                    <div class="contenedor_circulo">
                      <button href="#" class="h-100 mesaRedonda" id="<?php echo $mesa['id']; ?>" onclick="alert('Esta mesa está ocupada pero no se han realizado pedidos aún.')">
                        <img src="img/Mesa_Rosa.png" alt="mesa rosa">
                        <p class="numero-mesa"><?php echo $mesa['id']; ?></p>
                      </button>
                    </div>
                    <p class="card-text text-center blanco">Mesa Ocupada</p>
                  </div>
                <?php } elseif ($mesa['estado_mesa'] == 22) { ?>
                  <div class="">
                    <div class="contenedor_circulo">
                      <a href="pedido_mesa.php?mesa=<?php echo $mesa['id']; ?>">
                        <button class="h-100 mesaRedonda" id="<?php echo $mesa['id'] . "-link"; ?>">
                          <img src="img/Mesa_Roja.png" alt="mesa roja">
                          <p class="numero-mesa"><?php echo $mesa['id']; ?></p>
                        </button>
                      </a>
                    </div>
                    <p class="card-text text-center blanco">Pedido Realizado</p>
                  </div>
                <?php } elseif ($mesa['estado_mesa'] == 24) { ?>
                  <div class="">
                    <div class="contenedor_circulo">
                      <a href="pedido_mesa.php?mesa=<?php echo $mesa['id']; ?>">
                        <button href="" class="h-100 mesaRedonda" id="<?php echo $mesa['id']; ?>">
                          <img src="img/Mesa_Gris.png" alt="mesa gris">
                          <p class="numero-mesa"><?php echo $mesa['id']; ?></p>
                        </button>
                      </a>
                    </div>
                    <p class="card-text text-center blanco">Sin Pendientes</p>
                  </div>
                <?php } elseif ($mesa['estado_mesa'] == 25) { ?>
                  <div class="">
                    <div class="contenedor_circulo">
                      <a href="pedido_mesa.php?mesa=<?php echo $mesa['id']; ?>">
                        <button href="" class="h-100 mesaRedonda" id="<?php echo $mesa['id'] . "-link"; ?>">
                          <img src="img/Mesa_Verde.png" alt="mesa verde">
                          <p class="numero-mesa"><?php echo $mesa['id']; ?></p>
                        </button>
                      </a>
                    </div>
                    <p class="card-text text-center blanco">Mesa Cobrada</p>
                  </div>
                <?php } ?>
              </div>
            </div>

          <?php
          } // fin del foreach para cada mesa\n            
          ?>
        </div>
      <?php
      } // fin del foreach para cada grupo de mesas
      ?>
    </div>
    <button class="btn btn-info">
      <a href="/appResto/" class="btn negrita">Volver</a>
    </button>
  </div>

  <script>
    setInterval(function() {
      // location.reload();
    }, 20000); // 5000 milisegundos = 5 segundos
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
  </script>
</body>

</html>