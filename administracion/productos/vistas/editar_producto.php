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
$control = new ProductoController;
$producto = $control->mostrar_producto($_GET['id']);

?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Editar Producto</title>
	<link rel="stylesheet" href="css/estilos.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body data-bs-theme="dark">
    <div class="container">
    <h1>Editar Producto</h1>
    <form method="post" action="../controladores/ProductoController.php?accion=editar&id=<?php echo $producto['id'] ?>" enctype="multipart/form-data">
    <div class="mb-1">
        <label for="nombre" class="form-label">Nombre:</label>
        <input type="text" id="nombre" name="nombre_producto" value="<?php echo $producto['nombre_producto'] ?>" class="form-control">
    </div>
    <div class="mb-1">
        <label for="descripcion" class="form-label">Descripción:</label>
        <textarea id="descripcion" name="descripcion" class="form-control"><?php echo $producto['descripcion'] ?></textarea>
    </div>
    <div class="mb-1">
        <label for="precio" class="form-label">Precio:</label>
        <input type="number" id="precio" name="precio" step="0.01" value="<?php echo $producto['precio'] ?>" class="form-control">
    </div>
    <div class="mb-1">
        <label for="descuento" class="form-label">Descuento:</label>
        <input type="number" id="descuento" name="descuento" value="<?php echo $producto['descuento'] ?>" class="form-control">
    </div>
    <div class="mb-1">
        <label for="categoria" class="form-label">Categoría:</label>
        <select name="categoria" id="categoria" class="form-control" required>
            <option value="" <?php echo $producto['categoria'] == "" ? 'selected' : '' ?>>Seleccione una categoría</option>
            <option value="1" <?php echo $producto['categoria'] == 1 ? 'selected' : '' ?>>Bebida</option>
            <option value="2" <?php echo $producto['categoria'] == 2 ? 'selected' : '' ?>>Postre</option>
            <option value="3" <?php echo $producto['categoria'] == 3 ? 'selected' : '' ?>>Entrada</option>
            <option value="4" <?php echo $producto['categoria'] == 4 ? 'selected' : '' ?>>Plato Principal</option>
        </select><br><br>
    </div>
    <div class="mb-1">
        <label for="imagen" class="form-label">Imagen:</label>
        <input type="hidden" name="imagen_vieja" value="<?php echo $producto['imagen']; ?>" class="form-control">
        <?php if ($producto['imagen']): ?>
            <img src="<?php echo $producto['imagen'] ?>" alt="Imagen original del producto" class="img-fluid img-thumbnail w-25"><br>
        <?php else: ?>
            <p>No se ha cargado ninguna imagen</p><br>
        <?php endif; ?>
        <div>
            <label for="imagen" class="form-label">Imagen Nueva:</label>
            <input type="file" name="imagen" id="imagen" class="img-fluid img-thumbnail mt-2"><br>
        </div>
    </div>
    <div class="mt-2">
        <input type="submit" value="Guardar Cambios" class="btn btn-outline-success">
    </div>    
    </form>
    <div class="mt-2">
        <a href="mostrar_productos.php" class="btn btn-primary">Volver</a>
    </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
  </script>
</body>
</html>
