<?php
session_start();
//require_once "controladores/UsuarioControl.php";
if (isset($_SESSION['id_usu'])) {
    // Redirigir al formulario de inicio de sesión
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Iniciar sesión</title>
</head>
<body>
    <h2>Iniciar sesión</h2>
    <form method="post" action="controladores/UsuarioControl.php">
        <div>    
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label>Contraseña:</label>
            <input type="password" name="password" required><br>
        </div>
        <div>
            <input type="submit" value="Iniciar sesión">
        </div>
    </form>
</body>
</html>