<?php

require_once "BdModel.php";

class PacienteModel extends BdModel {
    public function obtenerPacientes() {
        try {
            $conexion = $this->db;
            $sql = "SELECT * FROM paciente";
            $resultado = $conexion->query($sql);

            if (!$resultado) {
                throw new Exception("Error al obtener los pacientes: " . $conexion->error);
            }

            $pacientes = array();

            while ($fila = $resultado->fetch_assoc()) {
                $pacientes[] = $fila;
            }

            return $pacientes;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return array();
        }
    }

    public function obtenerPacientePorDocumento($documento) {
        try {
            $conexion = $this->db;
            $sql = "SELECT * FROM paciente WHERE documento = ?";
            $stmt = $conexion->prepare($sql);

            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $conexion->error);
            }

            $stmt->bind_param('i', $documento);
            $stmt->execute();

            $resultado = $stmt->get_result();

            if (!$resultado) {
                throw new Exception("Error al obtener el paciente: " . $conexion->error);
            }

            $paciente = $resultado->fetch_assoc();

            return $paciente;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function agregarPaciente($documento, $telefono, $usu) {
        try {
            $usuario = intval($usu);
            $documento = intval($documento);
            $telefono = $this->db->real_escape_string($telefono);

            $sql = "INSERT INTO paciente (documento, telefono, id_usu) VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($sql);

            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $this->db->error);
            }

            $stmt->bind_param("isi", $documento, $telefono, $usuario);
            $stmt->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function editarPaciente($idPaciente, $nombre, $documento, $correo, $telefono) {
        try {
            $idPaciente = intval($idPaciente);
            $nombre = $this->db->real_escape_string($nombre);
            $documento = intval($documento);
            $correo = $this->db->real_escape_string($correo);
            $telefono = $this->db->real_escape_string($telefono);

            $sql = "UPDATE paciente SET nombre = ?, documento = ?, correo = ?, telefono = ? WHERE id_pac = ?";
            $stmt = $this->db->prepare($sql);

            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $this->db->error);
            }

            $stmt->bind_param("sissi", $nombre, $documento, $correo, $telefono, $idPaciente);
            $stmt->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function borrarPaciente($idPaciente) {
        try {
            $idPaciente = intval($idPaciente);

            $sql = "DELETE FROM paciente WHERE id_pac = ?";
            $stmt = $this->db->prepare($sql);

            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $this->db->error);
            }

            $stmt->bind_param("i", $idPaciente);
            $stmt->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
