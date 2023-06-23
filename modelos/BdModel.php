<?php

class BdModel {
    protected $db;

    public function __construct() {
        // Establecer la conexión a la base de datos
        $servidor = "localhost";
        $usuario = "root";
        $password = "";
        $base = "tpfinal";
        
        $this->db = new mysqli($servidor, $usuario, $password, $base);
        
        if ($this->db->connect_error) {
            die("Error de conexión a la base de datos: " . $this->db->connect_error);
        }        
    }
}

?>