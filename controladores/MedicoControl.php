<?php

require_once 'MedicoModel.php';
class MedicoController {
    private $model;

    public function __construct() {
        $this->model = new MedicoModel();
    }

    public function obtenerAgendaMedico($id_med) {
        return $this->model->obtenerAgendaMedico($id_med);
    }

    public function obtenerHistorialPacientes($id_med) {
        return $this->model->obtenerHistorialPacientes($id_med);
    }
}
