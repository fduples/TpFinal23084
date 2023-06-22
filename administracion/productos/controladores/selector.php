<?php
// Uso este selector para procesar los requerimientos del front y ejecutar la adecuada respuesta del controlador

//Instancio el controlador
require_once 'ProductoController.php';
$control = new ProductoController;

//verifico si hay una petición GET y si no la hay muestro los porductos por defecto
if (isset($_GET['accion'])) {
    $accion = $_GET['accion'];
} else {
    $accion = 'mostrar';
}

//con Switch buscamos el tipo de acción y ejecutamos la adecuada
switch ($accion) {
    case 'mostrarid':
        //mostramos un producto en particular y para esto el GET tiene que venir tanto con el valor del accion como con el id del producto que desean que muestre: ?accion=mostrarid&id=<id_producto>
        $control->mostrar_producto($_GET['id']);
        break;
    case 'agregar':
        //Ejecutamos el controlador de agregar producto cuando recibimos el formulario
        $control->agregar_producto();
        break;
    case 'mostrar':
        //mostramos un producto en particular y para esto el GET tiene que venir tanto con el valor del accion como con el id del producto que desean que muestre: ?accion=mostrarid&id=<id_producto>
        $control->mostrar_productos();
        break;
    case 'editar':
        //mostramos un producto en particular y para esto el GET tiene que venir tanto con el valor del accion como con el id del producto que desean que muestre: ?accion=mostrarid&id=<id_producto>
        $control->editar_producto($_GET['id']);
        break;
    case 'borrar':
        //mostramos un producto en particular y para esto el GET tiene que venir tanto con el valor del accion como con el id del producto que desean que muestre: ?accion=mostrarid&id=<id_producto>
        $control->borrar_producto($_GET['id']);
        break;

    //Dejamos por defecto la vista del menú
    default:
        $control->mostrar_productos();
        break;
}

?>