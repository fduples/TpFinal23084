<?php
session_start();
require_once "../Modelos/UsuarioModel.php";
if (isset($_GET['reg'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["usuario"];
        $password = $_POST["clave"];

        try {
            $usuario_model = new UsuarioModel();
            if(!$usuario_model->obtenerUsuarioPorCorreo($email)){
                $usuario_model->agregarUsuario("Sin Nombre",$email, $password);
            // Consultar la base de datos para verificar las credenciales utilizando la clase UsuarioModel
            }
                header("Location: ../vistas/acceso.php?reg"); // Redirige a la página principal después del inicio de sesión
            
        } catch (mysqli_sql_exception $e) {
            header("Location: ../vistas/acceso.php?error=" . $e->getMessage());
        }
    }
} else {
    // Procesar el formulario de inicio de sesión
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["usuario"];
        $password = $_POST["clave"];

        try {
            $usuario_model = new UsuarioModel();

            // Consultar la base de datos para verificar las credenciales utilizando la clase UsuarioModel
            $resultado = $usuario_model->obtenerUsuarioPorCorreo($email);

            if ($resultado && password_verify($password, $resultado['clave_usu'])) {
                // Inicio de sesión exitoso
                $_SESSION["loggedin"] = true;
                $_SESSION["email"] = $email;
                header("Location: ../vistas/index.php?log"); // Redirige a la página principal después del inicio de sesión
            } else {
                echo "Email o contraseña incorrectos.";
            }
        } catch (mysqli_sql_exception $e) {
            echo "Error al iniciar sesión: " . $e->getMessage();
        }
    }
}
?>