<?php
require_once "../config.php";
//require_once "../modelos/UsuarioModel.php";
require_once "../modelos/PacienteUsuarioModel.php";
session_start();
// Instancio el modelo de manejo de usuario de la base de datos
//$usuarioModel = new UsuarioModel();
$pacienteUsuarioModel = new PacienteUsuarioModel();
// Obtener la lista de pacientes y usuarios
$pacientesUsuarios = $pacienteUsuarioModel->obtenerPacientesUsuarios();

// Procesar la solicitud de edición
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['edita'])) {
    $idEdita = $_POST["idEdita"];
    $nombre = $_POST["nombre"];
    $documento = $_POST["documento"];
    $telefono = $_POST["telefono"];
    $correo = $_POST["usuario"];
    $permiso = $_POST["permisoEdita"];

    try {
        // Actualizar el usuario y paciente
        $pacienteUsuarioModel->editarUsuarioPaciente($idEdita, $nombre, $documento, $telefono, $correo, $permiso);

        header("Location: ../vistas/adminPaciente.php?editado=$idEdita"); // Redirigir a la página de administración con el mensaje de edición exitosa
    } catch (Exception $e) {
        header("Location: ../vistas/adminPaciente.php?noEditado=$idEdita"); // Redirigir a la página de administración con el mensaje de error en la edición
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
            //Verifico que el usuario y paciente no existan previamente
            if(!$pacienteUsuarioModel->obtenerUsuarioPorCorreo($email) && !$pacienteUsuarioModel->obtenerPacientePorDocumento($documento)){
                //Si no existe lo guardo en la base de datos y luego redirijo nuevamente a la pantalla de logueo
                
                if ($id_usu = $pacienteUsuarioModel->agregarUsuario($nombre,$email, $password, $permiso)) {
                    $pacienteUsuarioModel->agregarPaciente($documento, $telefono, $id_usu);
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
        $pacienteUsuarioModel->borrarUsuario($_GET['borrar_id']);
        header("Location: ../vistas/admin.php?borrado");
    } catch (mysqli_sql_exception $e) {
        header("Location: ../vistas/admin.php?Noborrado=" . $e->getMessage());
    }
   
} else {//Al no entrar al if porque no es registro entonces:
    // Procesar el formulario de inicio de sesión
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["usuario"];
        $password = $_POST["clave"];

        try {
            // Consultar la base de datos para verificar las credenciales utilizando la clase UsuarioModel
            $resultado = $pacienteUsuarioModel->obtenerUsuarioPorCorreo($email);

            if ($resultado && password_verify($password, $resultado['clave_usu'])) {
                // Inicio de sesión exitoso
                $_SESSION["loggedin"] = true;
                $_SESSION["email"] = $email;
                $_SESSION["permiso"] = $resultado['permiso_usu'];
                $_SESSION["id_usu"] = $resultado['id'];
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