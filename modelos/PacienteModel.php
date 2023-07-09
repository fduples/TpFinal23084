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

    public function obtenerPacienteUsuario($id_usu) {
        try {
            $conexion = $this->db;
            $sql = "SELECT * FROM paciente INNER JOIN usuarios ON paciente.id_usu = usuarios.id_usu WHERE usuarios.id_usu = ?";
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
    public function obtenerPacientesUsuarios() {
        try {
            $conexion = $this->db;
            $sql = "SELECT p.id_pac AS id_pac, p.documento AS documento, p.telefono AS telefono, u.nombre_usu AS nombre, u.correo_usu AS correo, u.permiso_usu AS permiso, u.id AS id
            FROM paciente p
            JOIN usuarios u ON p.id_usu = u.id";
    
            $stmt = $conexion->prepare($sql);
    
            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $conexion->error);
            }
    
            $stmt->execute();
            $resultado = $stmt->get_result();
    
            if (!$resultado) {
                throw new Exception("Error al obtener los pacientes y usuarios: " . $conexion->error);
            }
    
            $pacientesUsuarios = array();
    
            while ($fila = $resultado->fetch_assoc()) {
                $pacientesUsuarios[] = $fila;
            }
    
            return $pacientesUsuarios;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return array();
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
    
    public function borrarUsuarioPaciente($id) {
        try {
            $conexion = $this->db;
            
            // Borrar paciente
            $sqlPaciente = "DELETE FROM paciente WHERE id_usu = ?";
            $stmtPaciente = $conexion->prepare($sqlPaciente);
            
            if (!$stmtPaciente) {
                throw new Exception("Error al preparar la consulta de borrado de paciente: " . $conexion->error);
            }
            
            $stmtPaciente->bind_param("i", $id);
            
            if (!$stmtPaciente->execute()) {
                throw new Exception("Error al borrar el paciente: " . $stmtPaciente->error);
            }
            
            // Borrar usuario
            $sqlUsuario = "DELETE FROM usuarios WHERE id = ?";
            $stmtUsuario = $conexion->prepare($sqlUsuario);
            
            if (!$stmtUsuario) {
                throw new Exception("Error al preparar la consulta de borrado de usuario: " . $conexion->error);
            }
            
            $stmtUsuario->bind_param("i", $id);
            
            if (!$stmtUsuario->execute()) {
                throw new Exception("Error al borrar el usuario: " . $stmtUsuario->error);
            }
            
            return true;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    
}
