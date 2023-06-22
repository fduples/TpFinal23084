<?php
/*
* Este archio muestra los productos en una tabla.
*/
session_start();
include "php/conection.php";
$productos = new ClienteModel;
if (isset($_GET['mesa'])) {
	$mesa = $_GET['mesa'];
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Pedidos Mesa <?php echo $mesa ?></title>
	<link rel="stylesheet" href="estilosCliente.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body data-bs-theme="dark">
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h1>Carrito</h1>
			<a href="./products.php" class="btn btn-info">Productos</a>
			<br><br>
<?php
/*
* Esta es la consula para obtener todos los productos de la base de datos.
*/

if(isset($_SESSION["cart"]) && !empty($_SESSION["cart"])):
?>
<table class="table table-bordered">
<thead>
	<th>Cantidad</th>
	<th>Producto</th>
	<th>Precio Unitario</th>
	<th>Observación</th>
	<th></th>
</thead>
<?php 
/*
* Apartir de aqui hacemos el recorrido de los productos obtenidos y los reflejamos en una tabla.
*/
foreach($_SESSION["cart"] as $c):
$r = $productos->obtiene_producto($c['producto_id']);
$mesa = $c['mesa'];

	?>
<tr>
<th><?php echo $c["q"]; ?></th>
	<td><?php echo $r['nombre_producto']; ?></td>
	<td>$ <?php echo $r['precio']; ?></td>
	<td><?php echo $c['observacion']; ?></td>
	<td style="width:260px;">
	<?php
	$found = false;
	foreach ($_SESSION["cart"] as $c) { if($c["producto_id"]==$r['id']){ $found=true; break; }
}
	?>
		<a href="php/delfromcart.php?id=<?php echo $c["producto_id"];?>" class="btn btn-danger">Eliminar</a>
	</td>

</tr>

<?php endforeach; ?>
</table>

<form class="form-horizontal" method="post" action="./php/process.php">
  <div class="form-group">
    <label for="mesa" class="col-sm-2 control-label">número de mesa: <?php echo $mesa; ?></label>
    <div class="col-sm-5">
      <input type="hidden" name="mesa" required class="form-control" id="mesa" placeholder="mesa" value="<?php echo $mesa; ?>">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-primary">Enviar Pedido</button>
    </div>
  </div>
</form>
<?php else:?>
	<p class="alert alert-warning">No hay nuevos pedidos</p>
<?php endif;

$pedidos = $productos->verifica_estado_pedidos_mesa($mesa);
$total = 0;
$observacion = [];
if(!empty($pedidos)):
?>

</div class="container my-2">
        <div class="" id="<?php echo $mesa; ?>">
          <div class="card border-danger mb-3 border border-danger border-1 rounded-5 rounded-top-0 mt-1 align-midle">
            <div class="card-header bg-danger blanco text-center"><p class="blanco">Pedidos actuales de la Mesa <?php echo $mesa; ?></p></div>
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
                    foreach ($pedidos as $pedido) {
						$prod_pedido = $productos->obtiene_producto($pedido['producto']);
                      switch($pedido['estado']) {
                        case 1:
                          ?>
                          <tr scope="row">
                        <td scope="col" class="col-6"><?php echo $prod_pedido['nombre_producto']; ?></td>
                        <td scope="col" class="col-3"><?php echo '$' . $pedido['precio'];?></td>
                          <td scope="col" class="col-3 text-center">
                            <a scope="col" href="#" class="btn btn-warning mt-1 mb-1">
                              Pendiente
                            </a>
                          </td>
                          <?php
                          break;
                          case 5:
                            ?>
                            <tr scope="row" class="text-decoration-line-through text-danger">
                          <td scope="col" class="col-7"><?php echo $prod_pedido['nombre_producto']; ?></td>
                          <td scope="col" class="col-2"><?php echo '$' . $pedido['precio'];?></td>
                            <td scope="col" class="col-3">
                              <span scope="col" class="btn text-danger">
                                Anulado
                              </span>
                            </td>
                            <?php
                            break;
							case 2:
                          ?>
                          <tr scope="row">
						  <td scope="col" class="col-7"><?php echo $prod_pedido['nombre_producto']; ?></td>
                          <td scope="col" class="col-2"><?php echo '$' . $pedido['precio'];?></td>
                          <td scope="col">
                            <a scope="col" href="#" class="btn btn-success">
                              Entregado
                            </a>
                          </td>
                          <?php
                          break;
                      } ?>
                      </tr>
                    <?php  
                    $total += $pedido['precio'];
                    if ($pedido['observaciones'] != '') {
                      array_push($observacion,$prod_pedido['nombre_producto'] . ': ' . strtoupper($pedido['observaciones']));
                    }
                    
                  } 
                  $observaciones_mesa = implode(" - - ", $observacion);
                  ?>
                  </tbody>
                  <tfoot>
					<tr>
						<th colspan="3">OBSERVACIONES</th>
					</tr>
                    <tr>
                      <td colspan="3">
                        <?php echo $observaciones_mesa; ?>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">Total:</td>
                      <td class="fw-bold fs-3"><?php echo '$'.$total; ?></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </aside>
      

    </div>


<?php else:?>
	<p class="alert alert-warning">El carrito esta vacio.</p>
<?php endif;?>
		</div>
	</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
  </script>
</body>
</html>