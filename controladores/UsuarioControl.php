<?php
require_once "../config.php";
require_once "../Modelos/UsuarioModel.php";

session_start();

//Verifico si llega por get la variable reg y si es true inicio el registro:
if (isset($_GET['reg'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //Guardo el correo de usuario y la clave
        $email = $_POST["usuario"];
        $password = $_POST["clave"];

        try {
            //instancio el modelo de manejo de usuario de la base de datos
            $usuario_model = new UsuarioModel();
            //Verifico que el usuario no exista previamente
            if(!$usuario_model->obtenerUsuarioPorCorreo($email)){
                //Si no existe lo guardo en la base de datos y luego redirijo nuevamente a la pantalla de logueo
                $usuario_model->agregarUsuario("Sin Nombre",$email, $password);
                header("Location: ../vistas/acceso.php?reg"); // Redirige a la página principal después del inicio de sesión
            } else {
                //redirijo a la pagina de registro con la advertencia de que el ususario existe
                header("Location: ../vistas/registro.php?existe");
            }
            //si el try no funciona por error en la base de datos manejamos la exception y las enviamos como valor por get
        } catch (mysqli_sql_exception $e) {
            header("Location: ../vistas/registro.php?error=" . $e->getMessage());
        }
    }
} else {//Al no entrar al if porque no es registro entonces:
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
            } elseif (!$resultado){//Si el usuario no existe entonces vuelvo a la pagina de acceso con un atributo  para manejar en dicha pagina
                header("Location: ../vistas/acceso.php?noUsu");
            } else { //si la clave no funciona entonces devuelvo con otro atributo
                header("Location: ../vistas/acceso.php?noClave");
            }
        } catch (mysqli_sql_exception $e) { //Manejo un posible error de coneccion a la base de datos y lo devuelvo por get
            header("Location: ../vistas/acceso.php?error=" . $e->getMessage());
        }
    }
}
?>