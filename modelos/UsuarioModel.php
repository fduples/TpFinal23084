<?php 

require_once "BdModel.php";

class UsuarioModel extends BdModel {
    public function obtenerUsuarios() {
        try {
            $conexion = $this->db;
            $sql = "SELECT * FROM usuarios";
            $resultado = $conexion->query($sql);

            if (!$resultado) {
                throw new Exception("Error al obtener los usuarios: " . $conexion->error);
            }

            $usuarios = array();

            while ($fila = $resultado->fetch_assoc()) {
                $usuarios[] = $fila;
            }

            return $usuarios;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return array();
        }
    }

    public function obtenerUsuarioPorCorreo($correo_usu) {
        try {
            $conexion = $this->db;
            $sql = "SELECT * FROM usuarios WHERE correo_usu = ?";
            $stmt = $conexion->prepare($sql);

            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $conexion->error);
            }

            $stmt->bind_param('s', $correo_usu);
            $stmt->execute();

            $resultado = $stmt->get_result();

            if (!$resultado) {
                throw new Exception("Error al obtener el usuario: " . $conexion->error);
            }

            $usuario = $resultado->fetch_assoc();

            return $usuario;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    public function agregarUsuario($nombre_usu = "Sin Nombre", $correo_usu, $clave_usu, $permiso_usu = "Sin Nombre") {
        try {
            // Generar el hash de la contraseña
            $hashed_clave_usu = password_hash($clave_usu, PASSWORD_DEFAULT);

            $sql = "INSERT INTO usuarios (nombre_usu, correo_usu, clave_usu, permiso_usu) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);

            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $this->db->error);
            }

            $stmt->bind_param("ssss", $nombre_usu, $correo_usu, $hashed_clave_usu, $permiso_usu);
            $stmt->execute();
            // Obtener el ID del usuario insertado
            $id_usu = $this->db->insert_id;

            return $id_usu;
        } catch (Exception $e) {
            echo 'Error al agregar el usuario en la base de datos: ' . $e->getMessage();
            return false;
        }
    }

    public function actualizarUsuarioConClave($id_usu, $nombre_usu, $correo_usu, $clave_usu, $permiso_usu) {
        try {
            $sql = "UPDATE usuarios SET nombre_usu = ?, correo_usu = ?, clave_usu = ?, permiso_usu = ? WHERE id_usu = ?";
            $stmt = $this->db->prepare($sql);

            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $this->db->error);
            }

            $stmt->bind_param("ssssi", $nombre_usu, $correo_usu, $clave_usu, $permiso_usu, $id_usu);
            $stmt->execute();
        } catch (Exception $e) {
            echo 'Error al actualizar el usuario en la base de datos: ' . $e->getMessage();
        }
    }

    public function actualizarUsuarioSinClave($id_usu, $nombre_usu, $correo_usu, $permiso_usu) {
        try {
            $sql = "UPDATE usuarios SET nombre_usu = ?, correo_usu = ?, permiso_usu = ? WHERE id_usu = ?";
            $stmt = $this->db->prepare($sql);

            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $this->db->error);
            }

            $stmt->bind_param("sssi", $nombre_usu, $correo_usu, $permiso_usu, $id_usu);
            $stmt->execute();
        } catch (Exception $e) {
            echo 'Error al actualizar el usuario en la base de datos: ' . $e->getMessage();
        }
    }

    public function borrarUsuario($id_usu){
        try {
            $sql = "DELETE * FROM usuarios WHERE id_usu = ?";
            $stmt = $this->db->prepare($sql);

            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $this->db->error);
            }

            $stmt->bind_param("i", $id_usu);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            echo 'Error al actualizar el usuario en la base de datos: ' . $e->getMessage();
            return false;
        }
    }
}
