<?php
class AppController
{
    protected $route = false;
    protected $db;

    public function  __construct()
    {
        $request = explode('/', $_SERVER['REQUEST_URI']);
        array_shift($request);
        array_pop($request);
        $this->route = $request;
    }
    public function getRoute()
    {
        return $this->route;
    }

    public function respuesta($consulta)
    {
        $consulta = json_encode($consulta);
        header("Content-type: application/json; charset=utf-8");
        // header("cache-control: must-revalidate");
        header('Content-Length: ' . strlen($consulta));
        header('Vary: Accept-Encoding');
        echo ($consulta);
        exit();
    }
    // Conexión a la base de datos

    public function conectarDB()
    {
        try {
            $this->db = new PDO('mysql:host=' . SERVER . ';dbname=' . DB, USER, PASS);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->exec("SET CHARACTER SET utf8");
            return $this->db;
        } catch (PDOException $e) {
            echo $e->getMessage();
            //exit;
        }
    }
    public function desconectarDB()
    {
        $this->db = null;
    }
    public function getConexion()
    {
        return $this->db;
    }
}
