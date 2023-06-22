<?php
/*
* Agrega el producto a la variable de sesion de productos.
*/
session_start();


if(!empty($_POST)){
	if(isset($_POST["producto_id"]) && isset($_POST["q"])){
		// si es el primer producto simplemente lo agregamos
		if(empty($_SESSION["cart"])){
			$_SESSION["cart"]=array( array("producto_id"=>$_POST["producto_id"],"q" => $_POST["q"], "observacion" => $_POST['observaciones'], 'mesa' => $_POST['mesa'], "precio" => $_POST['precio']));
		}else{
			// apartir del segundo producto:
			$cart = $_SESSION["cart"];
			$repeated = false;
			// recorremos el carrito en busqueda de producto repetido
			/*foreach ($cart as $c) {
				// si el producto esta repetido rompemos el ciclo
				if($c["producto_id"]==$_POST["producto_id"]){
					$repeated=true;
					break;
				}
			}*/
			// si el producto es repetido no hacemos nada, simplemente redirigimos
			if($repeated){
				print "<script>alert('Error: Producto Repetido!');</script>";
			}else{
				// si el producto no esta repetido entonces lo agregamos a la variable cart y despues asignamos la variable cart a la variable de sesion
				array_push($cart, array("producto_id"=>$_POST["producto_id"],"q"=> $_POST["q"], "observacion" => $_POST['observaciones'], "mesa" => $_POST["mesa"], "precio" => $_POST["precio"]));
				$_SESSION["cart"] = $cart;
			}
		}
		print "<script>window.location='../products.php';</script>";
	}
}

?>

