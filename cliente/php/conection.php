<?php

$con  = new mysqli("localhost","root","","resto_nocountry");
class ClienteModel{
    private $pdo;
    public function __construct(){
        $this->pdo = new PDO('mysql:host=localhost;dbname=resto_nocountry;charset=utf8', 'root', '');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function obtiene_productos() {
    $select_query = "SELECT * FROM productos WHERE estado = 1";
    $stmt_select = $this->pdo->prepare($select_query);
    $stmt_select->execute();
    $result = $stmt_select->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

    public function obtiene_producto($producto_id) {
        $select_query = "SELECT * FROM productos WHERE id = :producto_id";
        $stmt_select = $this->pdo->prepare($select_query);
        $stmt_select->bindParam(':producto_id', $producto_id);
        $stmt_select->execute();
        $producto = $stmt_select->fetch(PDO::FETCH_ASSOC);
        return $producto;
    }

    public function inserta_pedidos($mesa, $producto_id, $precio, $observaciones) {
        $insert_query = "INSERT INTO pedidos (mesa, producto, cantidad, precio, descuento, estado, observaciones) VALUES (:mesa, :producto, 1, :precio, 0, 1, :observaciones)";
        $stmt = $this->pdo->prepare($insert_query);
        $stmt->bindParam(':mesa', $mesa);
        $stmt->bindParam(':producto', $producto_id);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':observaciones', $observaciones);

        return $stmt->execute();

    }

    public function verifica_estado_pedidos_mesa($id_mesa){
        $query = $this->pdo->prepare('SELECT * FROM pedidos WHERE NOT estado = 0 AND mesa = :mesa_id');
        $query->bindParam(":mesa_id", $id_mesa);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    

}


?>