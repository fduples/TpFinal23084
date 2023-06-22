<?php
if(!DEV){
    if(!isset($_SESSION["usuario"]) && $_SESSION["nivel_usuario"] !='admin'){
        $_SESSION = null;
        session_destroy();
        header('Location: ./');
    }
};
?>
<?php
if(!isset($_SESSION["usuario"]) && $_SESSION["nivel_usuario"] !='admin'){
$_SESSION = null;
session_destroy();
header('Location: ./');
};
?>
<!DOCTYPE html>
<html lang="es">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./administracion/css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Administración</title>
</head>

<body data-bs-theme="dark">
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <div>
                <h1>Administración</h1>
            </div>
            <div>
                <a href="./administracion/mesas/publico/admin_mesas.php" class="btn btn-primary btn-lg">
                    <img src="./administracion/img/mesas.png" alt="mesas" class="imgBotones">
                    Mesas
                </a>
                <a href="./administracion/productos/vistas/mostrar_productos.php" class="btn btn-primary btn-lg">
                    <img src="./administracion/img/productos.png" alt="mesas" class="imgBotones">
                    Productos
                </a>
                <a href="./logout.php" class="btn btn-primary btn-lg">
                    <img src="./assets/img/logout.svg" alt="mesas" class="imgBotones">
                    Salir
                </a>
            </div>
        </div>
    </nav>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
</body>

</html>