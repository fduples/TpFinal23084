<?php
require_once "../config.php";
require_once "../modelos/UsuarioModel.php";
require_once "../modelos/PacienteUsuarioModel.php";

session_start();

// Instancio el modelo de manejo de usuario de la base de datos
$usuarioModel = new UsuarioModel();
$pacienteUsuarioModel = new PacienteUsuarioModel();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['loggedin'])) {
    // Redirigir al formulario de inicio de sesión
    header("Location: acceso.php");
    exit;
}

// Verificar si el usuario es un administrador
if ($_SESSION['permiso'] !== 'administrador') {
    // Mostrar mensaje de acceso denegado
    echo 'Acceso denegado. No tienes los permisos necesarios para acceder a esta página.';
    header("Location: index.php?sinPermiso");
    exit;
}

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
}

// Procesar la solicitud de eliminación
if (isset($_GET['borrar_id'])) {
    $idBorrar = $_GET['borrar_id'];

    try {
        // Eliminar el paciente y usuario
        $pacienteUsuarioModel->borrarUsuarioPaciente($idBorrar);

        header("Location: ../vistas/adminPaciente.php?borrado"); // Redirigir a la página de administración con el mensaje de eliminación exitosa
    } catch (Exception $e) {
        header("Location: ../vistas/adminPaciente.php?noBorrado=" . $e->getMessage()); // Redirigir a la página de administración con el mensaje de error en la eliminación
    }
}

?>
