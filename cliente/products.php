<?php
/*
* Este archio muestra los productos en una tabla.
*/
session_start();
include "php/conection.php";
$productos = new ClienteModel;
if (isset($_GET[''])){
	if($_GET['mesa']) {
		$mesa = $_GET['mesa'];}
} else {
	$mesa = 1;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="estilosCliente.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body data-bs-theme="dark">
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h1>Productos</h1>
			<a href="./cart.php?mesa=<?php echo $mesa; ?>" class="btn btn-warning">Ver Carrito</a>
			<br><br>
<?php
/*
* Esta es la consula para obtener todos los productos de la base de datos.
*/
//$products = $con->query("select * from productos where estado = 1");
$products = $productos->obtiene_productos();
?>
<table class="table table-bordered">
<thead>
	<th>Producto</th>
	<th>Precio</th>
	<th>Descripción</th>
	<th>imagen</th>
	<th></th>
</thead>
<?php 
/*
* Apartir de aqui hacemos el recorrido de los productos obtenidos y los reflejamos en una tabla.
*/
foreach($products as $r){?>
<tr>
	<td><?php echo $r['nombre_producto'];?></td>
	<td>$ <?php echo $r['precio']; ?></td>
	<td><?php echo $r['descripcion']; ?></td>
	<td><img src="<?php echo $r['imagen']; ?>" alt=""></td>

	<td style="width:260px;">
	<?php
	$found = false;

	if(isset($_SESSION["cart"])){ foreach ($_SESSION["cart"] as $c) { if($c["producto_id"]==$r['id']){ $found=true; break; }}}
	//var_dump($_SESSION["cart"]);
	?>
	<?php if($found):?>
		<a href="cart.php" class="btn btn-info">Agregado</a>
	<?php else:?>
	<form class="form-inline" method="post" action="./php/addtocart.php">
	<input type="hidden" name="producto_id" value="<?php echo $r['id']; ?>">
	<input type="hidden" name="mesa" value="<?php echo $mesa ?>">
	<input type="hidden" name="precio" value="<?php echo $r['precio']; ?>">
	  <div class="form-group">
	    <input type="number" name="q" value="1" style="width:100px;" min="1" class="form-control" placeholder="Cantidad">
		<input type="text" name="observaciones" placeholder="Observación">
	  </div>
	  <button type="submit" class="btn btn-primary">Agregar al carrito</button>
	</form>	
	<?php endif; ?>
	</td>
</tr>
<?php }; ?>
</table>

		</div>
	</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
  </script>
</body>
</html>