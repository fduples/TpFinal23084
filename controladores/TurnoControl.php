<?php
require_once 'TurnoModel.php';
require_once 'EspecialidadModel.php';
require_once 'PacienteModel.php';

class TurnoController {
    private $model;

    public function __construct() {
        $this->model = new TurnoModel();
    }

    public function guardarTurno($id_med, $id_pac, $fecha, $hora) {
        return $this->model->guardarTurno($id_med, $id_pac, $fecha, $hora);
    }

    public function obtenerTurnosPaciente($id_pac) {
        return $this->model->obtenerTurnosPaciente($id_pac);
    }

    public function editarTurno($id_turno, $fecha, $hora) {
        return $this->model->editarTurno($id_turno, $fecha, $hora);
    }

    public function borrarTurno($id_turno) {
        return $this->model->borrarTurno($id_turno);
    }
}

class EspecialidadController {
    private $model;

    public function __construct() {
        $this->model = new EspecialidadModel();
    }

    public function obtenerEspecialidades() {
        return $this->model->obtenerEspecialidades();
    }
}

class PacienteController {
    private $model;

    public function __construct() {
        $this->model = new PacienteModel();
    }

    public function obtenerTurnosPaciente($id_pac) {
        return $this->model->obtenerTurnosPaciente($id_pac);
    }

    public function editarTurno($id_turno, $fecha, $hora) {
        return $this->model->editarTurno($id_turno, $fecha, $hora);
    }

    public function borrarTurno($id_turno) {
        return $this->model->borrarTurno($id_turno);
    }
}
?>
