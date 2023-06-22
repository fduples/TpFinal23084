<?php
var_dump($_SESSION);
   if(!isset($_SESSION["usuario"]) && $_SESSION["nivel_usuario"] !='admin'){
        $_SESSION = null;
        session_destroy();
        header('Location: /appResto/');
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Nuevo Producto</title>
	<link rel="stylesheet" href="css/estilos.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body data-bs-theme="dark">
    <div class="container">
    <h1>Carga de Productos</h1>
    <form action="../controladores/ProductoController.php?accion=agregar" method="post" enctype="multipart/form-data">
        <div>
        <label for="nombre_producto" class="form-label">Nombre del Producto:</label>
        <input type="text" name="nombre_producto" class="form-control" id="nombre_producto" required>
        </div>
        <div>
        <label for="descripcion" class="form-label">Descripción:</label>
        <textarea name="descripcion" id="descripcion" class="form-control" rows="5" cols="40" required></textarea>
        </div>
        <div>
        <label for="precio" class="form-label">Precio:</label>
        <input type="number" name="precio" id="precio" class="form-control" step=".01" min="0" required>
        </div>
        <div>
        <label for="descuento" class="form-label">Descuento (%):</label>
        <input type="number" name="descuento" id="descuento" class="form-control" min="0" max="100" required>
        </div>
        <div>
        <label for="imagen" class="form-label">Imagen:</label>
        <input type="file" name="imagen" id="imagen" class="form-control" required>
        </div>
        <div>
        <label for="categoria" class="form-label">Categoría:</label>
        <select name="categoria" id="categoria" class="form-control" required>
            <option value="">Seleccione una categoría</option>
            <option value="1">Bebida</option>
            <option value="2">Postre</option>
            <option value="3">Entrada</option>
            <option value="4">Plato Principal</option>
        </select><br><br>
        </select>
        </div>
        <div class="m-3">
        <input type="submit" value="Cargar Producto" class="btn btn-outline-success">
        </div>
    </form>
    <div class="m-3">
    <a href="mostrar_productos.php" class="btn btn-primary">volver</a> 
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
  </script>
</body>
</html>