<?php
require_once('config.php');
require_once('./lib/usuarioController.php');
$_SESSION = null;
session_destroy();
header('Location: /appResto/');
