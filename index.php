<?php

require_once('config.php');
require_once('./lib/usuarioController.php');
require_once('./lib/appController.php');
$app = new AppController();
$app->conectarDB();
$usuario = new UsuarioController();
if (isset($_POST) && !empty($_POST) && $_POST['human']) {
    $usuario->loginUsuario($_POST, $app->getConexion());
}
if (!isset($_SESSION['usuario']) || !$_SESSION['usuario']) {
    require_once('login.html');
} else {
    switch ($usuario->getNivelUsuario()) {
        case ('admin'):
            require_once('./administracion/admin.php');
            break;
        case ('mozo'):
            require_once('./mozo/publico/servicio.php');
            break;
    }
    //  debug($_SESSION, __LINE__);
}
