<?php
session_start();
   if(!isset($_SESSION["usuario"]) && $_SESSION["nivel_usuario"] !='admin'){
        $_SESSION = null;
        session_destroy();
        header('Location: /appResto/');
}
?>
<?php
require_once '../controladores/ProductoController.php';
$bd = new ProductoController;
$productos = $bd->mostrar_productos();
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Lista de Productos</title>
	<link rel="stylesheet" href="css/estilos.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<body data-bs-theme="dark">
	<div class="container">
		<nav class="navbar navbar-expand-lg bg-body-tertiary">
			<div class="container-fluid">
				<h1 class="text-danger fw-bold">Lista de productos</h1>
				<a href="agregar_producto.php" class="btn btn-outline-success">Agregar un nuevo producto</a>
				<button class="btn btn-info">
					<a href="/appResto/" class="btn btn-info">Volver</a>
				</button>
			</div>
		</nav>
		<div>
			<table class="table table-dark table-striped">
				<thead>
					<tr>
						<th scope="col" class="text-center align-middle">Nombre del producto</th>
						<th scope="col" class="text-center align-middle">Descripción</th>
						<th scope="col" class="text-center align-middle">Precio</th>
						<th scope="col" class="text-center align-middle">Descuento</th>
						<th scope="col" class="text-center align-middle">Categoría</th>
						<th scope="col" class="text-center align-middle">Imagen</th>
						<th scope="col" class="text-center align-middle">Acciones</th>
					</tr>
				</thead>
				<tbody class="table-group-divider">
					<?php foreach ($productos as $producto) : 
					    switch($producto['categoria']){
					        case(1):
    					       $categoria='Bebida';
	    				       break;
    				       case(2):
    					       $categoria='Postre';
	    				       break;
       				       case(3):
    					       $categoria='Entrada';
	    				       break;
       				       case(4):
    					       $categoria='Principal';
	    				       break;
	    				   default:
	    				       $categoria='Sin Cat.';
	    				    break;    
					    }
					?>
					
						<tr scope="row">
							<td class="text-center align-middle"><?php echo $producto['nombre_producto']; ?></td>
							<td class="text-center align-middle"><?php echo $producto['descripcion']; ?></td>
							<td class="text-center align-middle">$<?php echo $producto['precio']; ?></td>
							<td class="text-center align-middle"><?php echo $producto['descuento']; ?></td>
							<!--td class="text-center align-middle"><?php echo $producto['categoria']; ?></td-->
							<td class="text-center align-middle"><?php echo $categoria; ?></td>
							<td class="text-center align-middle"><img src="<?php echo $producto['imagen']; ?>" alt="Imagen del producto" style="width: 100px;"></td>
							<td class="text-center align-middle">
								<a href="<?php echo 'editar_producto.php?id=' . $producto['id']; ?>" class="btn btn-outline-warning mb-1">Editar</a>
								<a href="<?php echo '../controladores/ProductoController.php?accion=borrar&id=' . $producto['id']; ?>" class="btn btn-outline-danger">Borrar</a>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
	</script>
</body>

</html>