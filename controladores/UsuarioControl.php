<?php
session_start();
require_once "../Modelos/UsuarioModel.php";
if (isset($_GET['reg'])) {
    f ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["usuario"];
        $password = $_POST["clave"];

        try {
            $usuario_model = new UsuarioModel();

            // Consultar la base de datos para verificar las credenciales utilizando la clase UsuarioModel
            if($resultado = $usuario_model->obtenerUsuarioPorCorreo($email)){
                header("Location: registro.php?existe=$email");
                break;
            }

            if ($resultado && password_verify($password, $resultado['clave_usu'])) {
                // Inicio de sesión exitoso
                $_SESSION["loggedin"] = true;
                $_SESSION["email"] = $email;
                header("Location: index.php"); // Redirige a la página principal después del inicio de sesión
            } else {
                echo "Email o contraseña incorrectos.";
            }
        } catch (PDOException $e) {
            echo "Error al iniciar sesión: " . $e->getMessage();
        }
    }
} else {
    // Procesar el formulario de inicio de sesión
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $password = $_POST["password"];

        try {
            $usuario_model = new UsuarioModel();

            // Consultar la base de datos para verificar las credenciales utilizando la clase UsuarioModel
            $resultado = $usuario_model->obtenerUsuarioPorCorreo($email);

            if ($resultado && password_verify($password, $resultado['clave_usu'])) {
                // Inicio de sesión exitoso
                $_SESSION["loggedin"] = true;
                $_SESSION["email"] = $email;
                header("Location: index.php"); // Redirige a la página principal después del inicio de sesión
            } else {
                echo "Email o contraseña incorrectos.";
            }
        } catch (PDOException $e) {
            echo "Error al iniciar sesión: " . $e->getMessage();
        }
    }
}
?>