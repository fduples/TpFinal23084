<?php
require_once "BdModel.php";
class TurnoModel extends BdModel {
    public function guardarTurno($id_med, $id_pac, $fecha, $hora) {
        $sql = "INSERT INTO turno (id_med, id_pac, fecha, hora) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iiss", $id_med, $id_pac, $fecha, $hora);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function obtenerTurnosPaciente($id_pac) {
        $sql = "SELECT * FROM turno WHERE id_pac = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_pac);
        $stmt->execute();
        $result = $stmt->get_result();
        $turnos = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $turnos;
    }

    public function editarTurno($id_turno, $fecha, $hora) {
        $sql = "UPDATE turno SET fecha = ?, hora = ? WHERE id_turno = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssi", $fecha, $hora, $id_turno);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function borrarTurno($id_turno) {
        $sql = "DELETE FROM turno WHERE id_turno = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_turno);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>
