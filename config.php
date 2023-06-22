<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    $_SESSION['usuario'] = false;
}
//exit;'REQUEST_METHOD'
define('ENTORNO_LOCAL', false);
if (ENTORNO_LOCAL) {
    if (!defined('DEV')) {
        define('DEV', true);
        define('SERVER', 'localhost');
        define('USER', 'root');
        define('PASS', '');
        define('DB', 'resto_nocountry');
    }
} else {
    if (!defined('DEV')) {
        define('DEV', true);
        define('SERVER', 'localhost');
        define('USER', 'usuario');
        define('PASS', '*clave>');
        define('DB', 'db');
        define('ROOT', '/api/');
    }
}
if (DEV) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}
function debug($debug, $data = ' n/d')
{
    if (DEV) {
        echo '<pre>';
        //print_r($debug);
        var_dump($debug);
        echo '</pre>';
        echo PHP_EOL;
        echo ' Time: ' . time() . PHP_EOL . 'Data : ' . $data;
    }
}
function debugE($debug, $data = ' n/d')
{
    if (DEV) {
        echo '<pre>';
        //print_r($debug);
        var_dump($debug);
        echo '</pre>';
        echo PHP_EOL;
        echo ' Time: ' . time() . PHP_EOL . 'Data : ' . $data;
        exit();
    }
}
