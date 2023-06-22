<?php
require_once('mesaModel.php');
$mesas = new MesaModel;


if (isset($_GET['accion'])) {
    $accion = $_GET['accion'];
} else {
    $accion = 'mostrar';
}

//con Switch buscamos el tipo de acción y ejecutamos la adecuada
switch ($accion) {
    case 'cobrar':
        if (isset($_GET['idmesa'])) {
            $id_mesa = $_GET['idmesa'];
            $pedidos = $mesas->verifica_estado_pedidos_mesa($id_mesa);
            foreach ($pedidos as $pedido) {
                if ($pedido['estado'] == 2 || $pedido['estado'] == 5) {
                    $mesas->cambiarEstadoProductoMesa($pedido['id'],4);
                }
            }
            header('Location: ../publico/admin_mesas.php');
        } else {
            header('Location: ../publico/admin_mesas.php');
        }
        break;
    case 'servido':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $mesas->cambiarEstadoMesa($id, 20);
            header('Location: ../publico/servicio.php');
        } else {
            header('Location: ../publico/servicio.php');
        }
        break;
    case 'mesa':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $mesas->obtenerMesa($id);
            //header('Location: ../publico/servicio.php');
        }
        break;
            break;
        case 'addmesa':
            
            if (isset($_GET['qr'])) {
                $qr = $_GET['qr'];
                $mesas->insertarMesa($qr);
            }
            break;
        default://Establezco por defecto la verificación del estado de las mesas
            $mesas_disponibles = $mesas->obtenerMesas(); // función que retorna todas las mesas disponibles
            
            foreach ($mesas_disponibles as $mesa) {
                if($mesa['estado_mesa']==23){
                    continue;
                }
                $mesa_id = $mesa['id'];
                $lista_estados_pedidos = [];
                $pedidos = $mesas->verifica_estado_pedidos_mesa($mesa_id);
                $estado_mesa = null;
                foreach ($pedidos as $pedido) {
                    $estado_pedido = $pedido['estado'];
                    array_push($lista_estados_pedidos, $estado_pedido);
                }

                if (in_array(1, $lista_estados_pedidos)) {
                    $estado_mesa = 22;
                } elseif (in_array(2, $lista_estados_pedidos) || in_array(3, $lista_estados_pedidos)) {
                    $estado_mesa = 24;

                } elseif ((in_array(4, $lista_estados_pedidos) || in_array(5, $lista_estados_pedidos)) && !in_array(6, $lista_estados_pedidos)) {
                    $estado_mesa = 25;
                    
                }
                
                if (!is_null($estado_mesa)) {
                    // Actualizar el estado de la mesa en la tabla 'mesa'
                    $mesas->cambiarEstadoMesa($mesa_id, $estado_mesa);
                }
        }
        //verifica si hay pedidos en estado activo y luego actualiza el estado de las mesas segun esta respuesta
        $mozo = $mesas->obtenerMesas();
        break;
}

function obtener_info_pedidos_productos($mesa_id) {
    $mesas = new MesaModel;
    // traigo los pedidos para la mesa:
    $pedidos = $mesas->verifica_estado_pedidos_mesa($mesa_id);
  
    // declaro un array para almacenar la información de los productos:
    $productos_info = array();
  
    // Recorremos los pedidos y obtenemos la información de los productos relacionados:
    foreach ($pedidos as $pedido) {
      $pedido_id = $pedido['id'];
      $producto_id = $pedido['producto'];
      $estado_pedido = $pedido['estado'];
      $pedido_obs = $pedido['observaciones'];
      $producto = $mesas->productos_pedidos_mesa($producto_id);
      
      // Agrego la información del producto asociado al pedido al array que creé antes:
      $productos_info[] = array(
        'producto_id' => $producto['id'],
        'producto_nombre' => $producto['nombre_producto'],
        'producto_precio' => $producto['precio'],
        'producto_observacion' => $pedido_obs,
        'pedido-estado' => $estado_pedido,
        'pedido-id' => $pedido_id
      );
    }
    return $productos_info;
  }

?>
