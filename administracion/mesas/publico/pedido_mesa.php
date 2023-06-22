<?php
  /*  if(!isset($_SESSION["usuario"]) && $_SESSION["nivel_usuario"] !='admin'){
        $_SESSION = null;
        session_destroy();
        header('Location: /appResto/');
}*/
?>
<?php
require_once('../lib/controlMesa.php');
if (isset($_GET['mesa'])) {
    $mesa = $_GET['mesa'];
    $pedidos = obtener_info_pedidos_productos($mesa);
    $total = 0;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesa <?php echo $mesa; ?></title>
    <link rel="stylesheet" href="css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body data-bs-theme="dark">


<div class="container">
    <div>
    <div class="card border-danger mb-3 border border-danger border-1 rounded-5 rounded-top-0 mt-1 align-midle">
    <div class="card-header bg-danger blanco text-center">Pedidos Mesa <?php echo $mesa; ?></div>
    <div class="card-body">
        <div class="table table-responsive row">
            <table class="table-fixed col-10">
                <thead>
                    <tr>
                        <th class="text-center">Producto</th>
                        <th class="text-center">$</th>
                        <th class="text-center">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $observacion = [];
                    foreach ($pedidos as $pedido) {
                        $pendiente = false;
                        switch($pedido['pedido-estado']) {
                        case 1:
                            ?>
                            <tr scope="row">
                            <td scope="col" class="col-6 text-center"><?php echo $pedido['producto_nombre']; ?></td>
                            <td scope="col" class="col-3 text-center"><?php echo '$' . $pedido['producto_precio'];?></td>
                            <td scope="col" class="col-3 text-center">
                                <a scope="col" href="#" class="btn btn-success mt-1 mb-1">
                                    Entregar
                                </a>
                            </td>
                            <?php
                            $pendiente = true;
                            break;
                        case 2:
                            ?>
                        <tr scope="row">
                            <td scope="col" class="col-6 text-center"><?php echo $pedido['producto_nombre']; ?></td>
                            <td scope="col" class="col-3 text-center"><?php echo '$' . $pedido['producto_precio'];?></td>
                            <td scope="col" class="col-3 text-center">
                                <a scope="col" href="#" class="btn">
                                    Entregado
                                </a>
                            </td>
                        <?php
                        break;
                        case 5:
                        ?>
                        <tr scope="row" class="text-decoration-line-through text-danger">
                        <td scope="col" class="col-7 text-center"><?php echo $pedido['producto_nombre']; ?></td>
                        <td scope="col" class="col-2 text-center"><?php echo '$' . $pedido['producto_precio'];?></td>
                        <td scope="col" class="col-3 text-center">
                            <span scope="col" class="btn text-danger">
                            Anulado
                            </span>
                        </td>
                        <?php
                        break;
                        default:
                        ?>
                        <tr scope="row">
                        <td scope="col" class="col-7 text-center"><?php echo $pedido['producto_nombre']; ?></td>
                        <td scope="col" class="col-2 text-center"><?php echo '$' . $pedido['producto_precio'];?></td>
                        <td scope="col" class="col-3 text-center">
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
                    array_push($observacion,$pedido['producto_nombre'] . ': ' . strtoupper($pedido['producto_observacion']));
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
                    <td class="fw-bold fs-3 btn"><?php echo '$'.$total; ?></td>
                </tr>
                </tfoot>
            </table>
            <div class="col-2">
                <?php if ($pendiente) { ?>
                    <a href="#" class="btn btn-dark w-100 h-100 d-flex align-items-center"><p class="">MESA CON PENDIENTES DE ENTREGAR</p></a>
           <?php } else { ?>
                <a href="../lib/controlMesa.php?accion=cobrar&idmesa=<?php echo $mesa; ?>" class="btn btn-success w-100 h-100 d-flex align-items-center"><p class="">COBRAR MESA</p></a>
            <?php } ?>
            </div>
        </div>
    </div>
    </div>
    <div>
        <button class="btn btn-info">
            <a href="admin_mesas.php" class="btn negrita">Volver</a>
        </button>
    </div>
</div>
</body>
</html>