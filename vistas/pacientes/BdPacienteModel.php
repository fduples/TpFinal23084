<?php
require_once("../../config.php");

class BdPacienteModel {
    protected $db;

    public function __construct() {
        
        
        $this->db = new mysqli(SERVIDOR, USUARIO, CLAVE, BASE);
        
        if ($this->db->connect_error) {
            die("Error de conexión a la base de datos: " . $this->db->connect_error);
        }        
    }
}

?>