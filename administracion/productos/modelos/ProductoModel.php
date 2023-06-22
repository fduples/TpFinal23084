<?php

class ProductoModel {

    private $db;

    public function __construct() {
        $this->db = $this->conectarBD();
    }

    private function conectarBD() {
        try {
            $db = new PDO('mysql:host=localhost;dbname=resto_nocountry', 'root', '');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->exec("SET CHARACTER SET utf8");
            return $db;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            exit;
        }
    }

    public function agregarProducto($nombre_producto, $descripcion, $precio, $descuento, $imagen, $categoria) {


        $query = $this->db->prepare('INSERT INTO productos ( nombre_producto, descripcion, precio, descuento, imagen,  categoria) VALUES ( :nombre, :descripcion, :precio, :descuento, :imagen,  :categoria)');
        $query->bindParam(':nombre', $nombre_producto);
        $query->bindParam(':descripcion', $descripcion);
        $query->bindParam(':precio', $precio);
        $query->bindParam(':descuento', $descuento);
        $query->bindParam(':imagen', $imagen);
        $query->bindParam(':categoria', $categoria);
        $result = $query->execute();
         return $result;
    }

    public function obtenerProductos() {

        $sql = "SELECT * FROM productos";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProducto($id) {

        $sql = "SELECT * FROM productos WHERE id = :id";
        $query = $this->db->prepare($sql);
        $query->bindParam(':id', $id);
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarProducto($id_producto, $nombre_producto, $descripcion, $precio, $descuento, $imagen, $categoria) {
        try {
            $sql = "UPDATE productos SET nombre_producto = :nombre_producto, descripcion = :descripcion, precio = :precio, descuento = :descuento, imagen = :imagen, categoria = :categoria WHERE id = :id_producto";
            $query = $this->db->prepare($sql);
            $query->bindParam(':nombre_producto', $nombre_producto);
            $query->bindParam(':descripcion', $descripcion);
            $query->bindParam(':precio', $precio);
            $query->bindParam(':descuento', $descuento);
            $query->bindParam(':imagen', $imagen);
            $query->bindParam(':categoria', $categoria);
            $query->bindParam(':id_producto', $id_producto);
            $query->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function borrarProducto($id_producto){
        // Preparar consulta
        $sql = "DELETE FROM productos WHERE id = :idProducto";
        $query = $this->db->prepare($sql);
        $query->bindParam(':idProducto', $id_producto, PDO::PARAM_INT);

        // Ejecutar consulta
        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }
}