<?php
class MesaModel{
    private $pdo;
    public function __construct(){
        $this->pdo = new PDO('mysql:host=localhost;dbname=resto_nocountry;charset=utf8', 'root', '');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function verifica_estado_pedidos(){
        $query = $this->pdo->prepare('SELECT * FROM pedidos WHERE NOT estado = 0');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function verifica_estado_pedidos_mesa($id_mesa){
        $query = $this->pdo->prepare('SELECT * FROM pedidos WHERE NOT estado = 0 AND mesa = :mesa_id ORDER BY estado ASC');
        $query->bindParam(":mesa_id", $id_mesa);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cambiarEstadoMesa($idMesa, $nuevo_estado) {
        $sql = "UPDATE mesas SET estado_mesa = :estado WHERE id = :id";
        $query = $this->pdo->prepare($sql);
        $query->bindParam(':estado', $nuevo_estado);
        $query->bindParam(':id', $idMesa);
        return $query->execute();
      }

    public function cambiarEstadoPedido($idMesa, $nuevo_estado) {
        $pedidos = self::verifica_estado_pedidos_mesa($idMesa);
        foreach ($pedidos as $pedido) {
            $sql = "UPDATE pedidos SET estado = :estado WHERE id = :id";
            $query = $this->pdo->prepare($sql);
            $query->bindParam(':estado', $nuevo_estado);
            $query->bindParam(':id', $pedido['id']);
            $query->execute();
        }
        return true;
    }
    
    public function productos_pedidos_mesa($producto_id) {
        $sql = "SELECT * FROM productos WHERE id = :producto_id";
        $query = $this->pdo->prepare($sql);
        $query->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function cambiarEstadoProductoMesa($id_pedido, $nuevo_estado) {
        $sql = "UPDATE pedidos SET estado = :estado WHERE id = :id";
        $query = $this->pdo->prepare($sql);
        $query->bindParam(':estado', $nuevo_estado);
        $query->bindParam(':id', $id_pedido);
        $query->execute();
        return true;
    }
      

    public function insertarMesa($estado_mesa, $qr){
        $stmt = $this->pdo->prepare('INSERT INTO mesas (estado_mesa, qr) VALUES (:estado_mesa, :qr)');
        $stmt->bindParam(':estado_mesa', $estado_mesa);
        $stmt->bindParam(':qr', $qr);
        $stmt->execute();
        return $this->pdo->lastInsertId();
    }

    public function actualizarMesa($id, $estado_mesa, $qr){
        $query = $this->pdo->prepare('UPDATE mesas SET estado_mesa=:estado_mesa, qr=:qr WHERE id=:id');
        $query->bindParam(':id', $id);
        $query->bindParam(':estado_mesa', $estado_mesa);
        $query->bindParam(':qr', $qr);
        return $query->execute();
        $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerMesas() {
        $query = $this->pdo->prepare('SELECT * FROM mesas');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function borrarMesa($id){
        $query = $this->pdo->prepare('DELETE FROM mesas WHERE id=:id');
        $query->bindParam(':id', $id);
        return $query->execute();
    }

    public function obtenerMesa($id){
        $query = $this->pdo->prepare('SELECT * FROM mesas WHERE id=:id');
        $query->bindParam(':id', $id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}


?>