<?php

require_once "BdPacienteModel.php";

class PacienteModel extends BdPacienteModel {
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
    public function editarUsuarioPaciente($id, $nombre, $documento, $telefono, $correo, $permiso) {
        try {
            $conexion = $this->db;
            
            // Actualizar usuario
            $sqlUsuario = "UPDATE usuarios SET nombre_usu = ?, correo_usu = ?, permiso_usu = ? WHERE id = ?";
            $stmtUsuario = $conexion->prepare($sqlUsuario);
            
            if (!$stmtUsuario) {
                throw new Exception("Error al preparar la consulta de actualización de usuario: " . $conexion->error);
            }
            
            $stmtUsuario->bind_param("sssi", $nombre, $correo, $permiso, $id);
            
            if (!$stmtUsuario->execute()) {
                throw new Exception("Error al actualizar el usuario: " . $stmtUsuario->error);
            }
            
            // Actualizar paciente
            $sqlPaciente = "UPDATE paciente SET documento = ?, telefono = ? WHERE id_usu = ?";
            $stmtPaciente = $conexion->prepare($sqlPaciente);
            
            if (!$stmtPaciente) {
                throw new Exception("Error al preparar la consulta de actualización de paciente: " . $conexion->error);
            }
            
            $stmtPaciente->bind_param("ssi", $documento, $telefono, $id);
            
            if (!$stmtPaciente->execute()) {
                throw new Exception("Error al actualizar el paciente: " . $stmtPaciente->error);
            }
            
            return true;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    
    public function obtenerPacienteUsuario($id_usu) {
        try {
            $conexion = $this->db;
            $sql = "SELECT * FROM paciente INNER JOIN usuarios ON paciente.id_usu = usuarios.id WHERE paciente.id_usu = ?";
            $stmt = $conexion->prepare($sql);

            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $conexion->error);
            }

            $stmt->bind_param('i', $id_usu);
            $stmt->execute();

            $resultado = $stmt->get_result();

            if (!$resultado) {
                throw new Exception("Error al obtener el paciente/usuario: " . $conexion->error);
            }

            $pacienteUsuario = $resultado->fetch_assoc();

            return $pacienteUsuario;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
}
