<?php 
session_start();
include "conection.php";
$pedido = new ClienteModel;

if(!empty($_POST)){
foreach($_SESSION["cart"] as $c){
    foreach ($c as $key => $value) {
        echo $key . ": " . $value . "\n";
       
    }
    for ($i=0; $i < $c['q']; $i++) { 
        try {
            $pedido->inserta_pedidos($c['mesa'], $c['producto_id'], $c['precio'], $c['observacion']);
        } catch (PDOException $e) {
            $msg = "Error: " . $e->getMessage();
            echo $msg;
            return false;
        }
    }
}
unset($_SESSION["cart"]);
}

print "<script>alert('Venta procesada exitosamente');window.location='../products.php';</script>";
?>