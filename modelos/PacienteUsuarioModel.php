<?php

require_once "BdModel.php";

class PacienteUsuarioModel extends BdModel {
    public function obtenerPacientes() {
        // Implementación del método obtenerPacientes
    }

    public function obtenerPacientePorDocumento($documento) {
        // Implementación del método obtenerPacientePorDocumento
    }

    public function agregarPaciente($documento, $telefono, $usu) {
        // Implementación del método agregarPaciente
    }

    public function editarPaciente($idPaciente, $nombre, $documento, $correo, $telefono) {
        // Implementación del método editarPaciente
    }

    public function borrarPaciente($idPaciente) {
        // Implementación del método borrarPaciente
    }

    public function obtenerUsuarios() {
        // Implementación del método obtenerUsuarios
    }

    public function obtenerUsuarioPorCorreo($correo_usu) {
        // Implementación del método obtenerUsuarioPorCorreo
    }

    public function agregarUsuario($nombre_usu = "Sin Nombre", $correo_usu, $clave_usu, $permiso_usu = "Sin Nombre") {
        // Implementación del método agregarUsuario
    }

    public function actualizarUsuarioConClave($id_usu, $nombre_usu, $correo_usu, $clave_usu, $permiso_usu) {
        // Implementación del método actualizarUsuarioConClave
    }

    public function actualizarUsuarioSinClave($id_usu, $nombre_usu, $correo_usu) {
        // Implementación del método actualizarUsuarioSinClave
    }

    public function borrarUsuario($id_usu) {
        // Implementación del método borrarUsuario
    }

    public function obtenerPacienteUsuario($id_usu) {
        try {
            $conexion = $this->db;
            $sql = "SELECT * FROM paciente INNER JOIN usuarios ON paciente.id_usu = usuarios.id_usu WHERE pacientes.id_usu = ?";
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
            $sql = "SELECT p.id_pac AS id, p.documento AS documento, p.telefono AS telefono, u.nombre_usu AS nombre_usuario, u.correo_usu AS correo
                    FROM paciente p
                    JOIN usuarios u ON p.id_usu = u.id";
    
            $resultado = $conexion->query($sql);
    
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
    
    
}
