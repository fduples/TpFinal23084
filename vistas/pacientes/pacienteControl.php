<?php
require_once "PacienteModel.php";

session_start();

// Instancio el modelo de manejo de usuario de la base de datos
$pacienteModel = new PacienteModel();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['loggedin'])) {
    // Redirigir al formulario de inicio de sesión
    header("Location: acceso.php");
    exit;
}

// Verificar si el usuario es un administrador
if ($_SESSION['permiso'] !== 'paciente') {
    // Mostrar mensaje de acceso denegado
    echo 'Acceso denegado. No tienes los permisos necesarios para acceder a esta página.';
    header("Location: index.php?sinPermiso");
    exit;
}

// Obtener la lista de pacientes y usuarios
$pacientesUsuarios = $pacienteModel->obtenerPacienteUsuario($_SESSION['id_usu']);

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
        $pacienteModel->editarUsuarioPaciente($idEdita, $nombre, $documento, $telefono, $correo, $permiso);

        header("Location: ../index.php?editado=$idEdita"); // Redirigir a la página de administración con el mensaje de edición exitosa
    } catch (Exception $e) {
        header("Location: ../vistas/paciente/perfil.php?noEditado=$idEdita"); // Redirigir a la página de administración con el mensaje de error en la edición
    }
}


?>
