<?php

require_once "BdModel.php";
class MedicoModel extends BdModel {
    public function obtenerAgendaMedico($id_med) {
        $sql = "SELECT turno.fecha, turno.hora, paciente.documento, paciente.telefono FROM turno INNER JOIN paciente ON turno.id_pac = paciente.id_pac WHERE turno.id_med = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_med);
        $stmt->execute();
        $result = $stmt->get_result();
        $agenda = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $agenda;
    }

    public function obtenerHistorialPacientes($id_med) {
        $sql = "SELECT DISTINCT paciente.documento, paciente.telefono FROM turno INNER JOIN paciente ON turno.id_pac = paciente.id_pac WHERE turno.id_med = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_med);
        $stmt->execute();
        $result = $stmt->get_result();
        $pacientes = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $pacientes;
    }
}
?>