<?php
require_once "../config.php";
require_once "../Modelos/UsuarioModel.php";
require_once "../Modelos/PacienteModel.php";

session_start();

//instancio el modelo de manejo de usuario de la base de datos
$usuario_model = new UsuarioModel();

//Verifico si llega por get la variable reg y si es true inicio el registro:
if(isset($_GET['edita'])){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //Guardo el correo de usuario y la clave
        $nombre = $_POST["nombre"];
        $correo = $_POST["usuario"];
        $id_usu = $_POST["idEdita"];

        try {
            //Verifico que el usuario existan previamente
            if($usuario_model->obtenerUsuarioPorCorreo($correo)){
                //Si existe lo guardo en la base de datos y luego redirijo nuevamente a la pantalla de admin
                
                if ($e = $usuario_model->actualizarUsuarioSinClave($id_usu, $nombre, $correo)) {
                    header("Location: ../vistas/admin.php?editado=$id_usu"); // Redirige a la página de administracion
                } else {
                    //redirijo a la pagina de registro con la advertencia de que el ususario no fue editado
                    header("Location: ../vistas/admin.php?noEditado=$id_usu");
                } 
            }
            //si el try no funciona por error en la base de datos manejamos la exception y las enviamos como valor por get
        } catch (mysqli_sql_exception $e) {
            header("Location: ../vistas/registro.php?error=" . $e->getMessage());
        }
    }
} elseif (isset($_GET['reg'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //Guardo el correo de usuario y la clave
        $nombre = $_POST["nombre"];
        $documento = $_POST["documento"];
        $email = $_POST["usuario"];
        $telefono = $_POST["telefono"];
        $password = $_POST["clave"];
        $permiso = $_POST["permiso"];
        try {
            $paciente = new PacienteModel();
            //Verifico que el usuario y paciente no existan previamente
            if(!$usuario_model->obtenerUsuarioPorCorreo($email) && !$paciente->obtenerPacientePorDocumento($documento)){
                //Si no existe lo guardo en la base de datos y luego redirijo nuevamente a la pantalla de logueo
                
                if ($id_usu = $usuario_model->agregarUsuario($nombre,$email, $password, $permiso)) {
                    $paciente->agregarPaciente($documento, $telefono, $id_usu);
                }
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
}elseif (isset($_GET['borrar_id'])) {
    try {
        $usuario_model->borrarUsuario($_GET['borrar_id']);
        header("Location: ../vistas/admin.php?borrado");
    } catch (mysqli_sql_exception $e) {
        header("Location: ../vistas/admin.php?borrado=" . $e->getMessage());
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
                $_SESSION["permiso"] = $resultado['permiso_usu'];
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