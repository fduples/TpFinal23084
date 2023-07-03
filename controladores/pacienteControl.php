<?php

require_once "PacienteModel.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $_POST["nombre"];
    $documento = $_POST["documento"];
    $correo = $_POST["correo"];
    $telefono = $_POST["telefono"];

    // Crear una instancia del modelo
    $pacienteModel = new PacienteModel();

    //Si no existe previamente un paciente con ese documento
    if (!$pacienteModel->obtenerPacientePorDocumento($documento)) {
        // Agregar el paciente a la base de datos
        $pacienteModel->agregarPaciente($nombre, $documento, $correo, $telefono);

    // Redireccionar a una página de éxito o mostrar un mensaje
    header("Location: acceso.php?regOk");
    exit();
    }

    
    
}
