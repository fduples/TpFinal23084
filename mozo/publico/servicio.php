<?php
//session_start();
   if(!isset($_SESSION["usuario"]) && $_SESSION["nivel_usuario"] !='mozo'){
        $_SESSION = null;
        session_destroy();
        header('Location: /appResto/');
}
?>
<?php
require_once('./mozo/lib/controlMesa.php');

?>

<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Servicio <?php echo "NOMBRE MOZO" ?></title>
  <link rel="stylesheet" href="./mozo/publico/css/estilos.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<body data-bs-theme="dark">

  <div class="container">

    <div class="row">
      <div class="col-7">
        <h1 class="text-center bg-danger border border-danger border-1 rounded-5 rounded-top-0 mt-1 align-midle p-2">Mesas</h1>
        <a href="?" class="btn btn-primary btn-lg">
          Cerrar vista pedido
        </a>
        <a href="./logout.php" class="btn btn-primary btn-lg">
          <img src="./assets/img/logout.svg" alt="mesas" class="imgBotones">
          Salir
        </a>
        <?php
        $chunked_mesas = array_chunk($mozo, 2); // dividir las mesas en grupos de 3
        foreach ($chunked_mesas as $grupo_mesas) { // recorrer cada grupo de mesas
        ?>

          <div class="row row-cols-2 g-6 mb-1">

            <?php
            foreach ($grupo_mesas as $mesa) { // recorrer cada mesa dentro del grupo
            ?>
              <div class="col">
                <div class="card h-100">
                  <div class="card-body">

                    <?php

                    //establecemos los posibles estados de las mesas y segun el estado lo que debe mostrar
                    if ($mesa['estado_mesa'] == 23) { ?>
                      <div class="">
                        <form method="GET" action="./mozo/lib/controlMesa.php" onsubmit="return confirm('¿se atendió la mesa?')">
                          <input type="hidden" name="accion" value="servido">
                          <input type="hidden" name="id" value="<?php echo $mesa['id']; ?>">
                          <div class="contenedor_circulo">
                            <button tipe="submit" href="./mozo/lib/controlMesa.php?accion=servido&id=<?php echo $mesa['id']; ?>" class="h-100 mesaRedonda" id="<?php echo $mesa['id']; ?>">
                              <img src="./mozo/publico/img/Mesa_Amarilla.png" alt="mesa amarilla">
                              <p class="numero-mesa"><?php echo $mesa['id']; ?></p>
                            </button>
                          </div>
                          <p class="card-text text-center blanco">Requiere Servicio</p>
                          <p class="card-text ">Tocar para asentar servicio</p>
                        </form>
                        <a href="<?php echo '?mesa=' . $mesa['id']; ?>" class="btn bg-warning bg-gradient h-100 w-100 mt-1 negrita" id="<?php echo $mesa['id'] . "-link"; ?>">Ver Pedido</a>
                      </div>
                    <?php
                    } elseif ($mesa['estado_mesa'] == 20) {
                    ?>
                      <div class="">
                        <div class="contenedor_circulo">
                          <button href="#" class="h-100 mesaRedonda" id="<?php echo $mesa['id'] . "-link"; ?>" onclick="alert('Esta mesa está libre, no hay pedidos.')">
                            <img src="./mozo/publico/img/Mesa_Blanca.png" alt="mesa blanca">
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
                            <img src="./mozo/publico/img/Mesa_Rosa.png" alt="mesa rosa">
                            <p class="numero-mesa"><?php echo $mesa['id']; ?></p>
                          </button>
                        </div>
                        <p class="card-text text-center blanco">Mesa Ocupada</p>
                      </div>
                    <?php } elseif ($mesa['estado_mesa'] == 22) { ?>
                      <div class="">
                        <div class="contenedor_circulo">
                          <a href="<?php echo '?mesa=' . $mesa['id']; ?>">
                            <button class="h-100 mesaRedonda" id="<?php echo $mesa['id'] . "-link"; ?>">
                              <img src="./mozo/publico/img/Mesa_Roja.png" alt="mesa blanca">
                              <p class="numero-mesa"><?php echo $mesa['id']; ?></p>
                            </button>
                          </a>
                        </div>
                        <p class="card-text text-center blanco">Pedido Realizado</p>
                      </div>
                    <?php } elseif ($mesa['estado_mesa'] == 24) { ?>
                      <div class="">
                        <div class="contenedor_circulo">
                          <a href="<?php echo '?mesa=' . $mesa['id']; ?>">
                            <button href="" class="h-100 mesaRedonda" id="<?php echo $mesa['id']; ?>">
                              <img src="./mozo/publico/img/Mesa_Gris.png" alt="mesa gris">
                              <p class="numero-mesa"><?php echo $mesa['id']; ?></p>
                            </button>
                          </a>
                        </div>
                        <p class="card-text text-center blanco">Sin Pendientes</p>
                      </div>
                    <?php } elseif ($mesa['estado_mesa'] == 25) { ?>
                      <div class="">
                        <form method="GET" action="./mozo/lib/controlMesa.php?accion=cerrar&id=<?php echo $mesa['id']; ?>" onsubmit="return confirm('¿Está seguro de cerrar la mesa?')">
                          <input type="hidden" name="accion" value="cerrar">
                          <input type="hidden" name="id" value="<?php echo $mesa['id']; ?>">
                          <div class="">
                            <div class="contenedor_circulo">
                              <button type="submit" href="" class="h-100 mesaRedonda" id="<?php echo $mesa['id']; ?>">
                                <img src="./mozo/publico/img/Mesa_Verde.png" alt="mesa verde">
                                <p class="numero-mesa"><?php echo $mesa['id']; ?></p>
                              </button>
                            </div>
                            <p class="card-text text-center blanco">Mesa Cobrada</p>
                          </div>
                        </form>
                        <a href="<?php echo '?mesa=' . $mesa['id']; ?>" class="btn bg-warning bg-gradient h-100 w-100 mt-1 negrita" id="<?php echo $mesa['id'] . "-link"; ?>">Ver Pedido</a>
                      </div>
                    <?php } ?>
                  </div>
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
      <?php
      foreach ($mozo as $mesa) {
        if (isset($_GET['mesa']) && $_GET['mesa'] == $mesa['id']) {
          $visible = 'visibles';
        } else {
          $visible = 'ocultas';
        }
      ?>

        <aside class="col-5 <?php echo $visible; ?>" id="<?php echo $mesa['id']; ?>">
          <div class="card border-danger mb-3 border border-danger border-1 rounded-5 rounded-top-0 mt-1 align-midle">
            <div class="card-header bg-danger blanco text-center">Pedidos Mesa <?php echo $mesa['id']; ?></div>
            <div class="card-body">
              <div class="table table-responsive">
                <table class="table-fixed">
                  <thead>
                    <tr>
                      <th class="text-center">Producto</th>
                      <th class="text-center">$</th>
                      <th class="text-center">Estado</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $pedidos = obtener_info_pedidos_productos($mesa['id']);
                    $total = 0;
                    $observacion = [];
                    foreach ($pedidos as $pedido) {
                      switch ($pedido['pedido-estado']) {
                        case 1:
                    ?>
                          <tr scope="row">
                            <td scope="col" class="col-6"><?php echo $pedido['producto_nombre']; ?></td>
                            <td scope="col" class="col-3"><?php echo '$' . $pedido['producto_precio']; ?></td>
                            <td scope="col" class="col-3 text-center">
                              <a scope="col" href="./mozo/lib/controlMesa.php?accion=entregado&id=<?php echo $pedido['pedido-id']; ?>&idmesa=<?php echo $mesa['id']; ?>" class="btn btn-success mt-1 mb-1">
                                Entregar
                              </a>
                            </td>
                          <?php
                          break;
                        case 5:
                          ?>
                          <tr scope="row" class="text-decoration-line-through text-danger">
                            <td scope="col" class="col-7"><?php echo $pedido['producto_nombre']; ?></td>
                            <td scope="col" class="col-2"><?php echo '$' . $pedido['producto_precio']; ?></td>
                            <td scope="col" class="col-3">
                              <span scope="col" class="btn text-danger">
                                Anulado
                              </span>
                            </td>
                          <?php
                          break;
                        default:
                          ?>
                          <tr scope="row">
                            <td scope="col"><?php echo $pedido['producto_nombre']; ?></td>
                            <td scope="col"><?php echo '$' . $pedido['producto_precio']; ?></td>
                            <td scope="col">
                              <a scope="col" href="#" class="btn">
                                Entregado
                              </a>
                            </td>
                        <?php
                          break;
                      } ?>
                          </tr>
                        <?php
                        $total += $pedido['producto_precio'];
                        if ($pedido['producto_observacion'] != '') {
                          array_push($observacion, $pedido['producto_nombre'] . ': ' . strtoupper($pedido['producto_observacion']));
                        }
                      }
                      $observaciones_mesa = implode(" - - ", $observacion);
                        ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="3">
                        <?php echo $observaciones_mesa; ?>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">Total:</td>
                      <td class="fw-bold fs-3 align-middle"><?php echo '$' . $total; ?></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </aside>
      <?php } ?>

    </div>
  </div>

  <script>
    setInterval(function() {
      location.reload();
    }, 15000); // 5000 milisegundos = 5 segundos
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
  </script>
</body>

</html>