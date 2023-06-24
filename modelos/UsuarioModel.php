<?php
require_once "BdModel.php";
class UsuarioModel extends BdModel {
    public function obtenerUsuarios() {
        $coneccion = $this->db;
        $sql = "SELECT * FROM usuarios";
        $resultado = $coneccion->query($sql);
        $rows = array();
        while($row = $resultado->fetch_assoc()) {
           $rows[] = $row;
        }
        return $rows;
     }
     public function obtenerUsuarioPorCorreo($correo_usu) {
        $coneccion = $this->db;
        $sql = "SELECT * FROM usuarios WHERE correo_usu = ?";
        $stmt = $coneccion->prepare($sql);
        $stmt->bind_param('s', $correo_usu);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $data = $resultado->fetch_assoc();
        return $data;
    }
    
    public function agregarUsuario($nombre_usu="Sin Nombre", $correo_usu, $clave_usu, $permiso_usu="Sin Nombre") {
        // Generar el hash de la contraseña
        $hashed_clave_usu = password_hash($clave_usu, PASSWORD_DEFAULT);
    
        try {
            // Prepara la consulta SQL
            $sql = "INSERT INTO usuarios (nombre_usu, correo_usu, clave_usu, permiso_usu) VALUES (?, ?, ?, ?)";
    
            // Ejecuta la consulta preparada
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ssss", $nombre_usu, $correo_usu, $hashed_clave_usu, $permiso_usu);
            $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            echo 'Error al agregar el usuario en la base de datos: ' . $e->getMessage();
        }
    }
    
    public function actualizarUsuarioConClave($id_usu, $nombre_usu, $correo_usu, $clave_usu, $permiso_usu) {
        try {
            // Prepara la consulta SQL
            $sql = "UPDATE usuarios SET nombre_usu = ?, correo_usu = ?, clave_usu = ?, permiso_usu = ? WHERE id_usu = ?";
    
            // Ejecuta la consulta preparada
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ssssi", $nombre_usu, $correo_usu, $clave_usu, $permiso_usu, $id_usu);
            $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            echo 'Error al actualizar el usuario en la base de datos: ' . $e->getMessage();
        }
    }
    
    public function actualizarUsuarioSinClave($id_usu, $nombre_usu, $correo_usu, $permiso_usu) {
        try {
            // Prepara la consulta SQL
            $sql = "UPDATE usuarios SET nombre_usu = ?, correo_usu = ?, permiso_usu = ? WHERE id_usu = ?";
    
            // Ejecuta la consulta preparada
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("sssi", $nombre_usu, $correo_usu, $permiso_usu, $id_usu);
            $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            echo 'Error al actualizar el usuario en la base de datos: ' . $e->getMessage();
        }
    }
    
    
}


?>