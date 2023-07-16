<?php
require_once "BdModel.php";
class EspecialidadModel extends BdModel {
    public function obtenerEspecialidades() {
        $sql = "SELECT * FROM especialidad";
        $result = $this->db->query($sql);
        $especialidades = $result->fetch_all(MYSQLI_ASSOC);
        return $especialidades;
    }
}
?>