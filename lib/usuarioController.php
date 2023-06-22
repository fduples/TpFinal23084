<?php
class UsuarioController
{
    private $usuario;

    public function  __construct()
    {
        $this->usuario = $_SESSION['usuario'];
    }
    public function getUsuario()
    {
        return $this->usuario;
    }
    public function getNombre()
    {
        return @$this->usuario['nombre'];
    }
    public function getNivelUsuario()
    {
        return @$this->usuario['nivel_usuario'];
    }

    public function loginUsuario($post, $conn)
    {
        // $stmt = $conn->prepare("SELECT * FROM `user` WHERE `email` = :usuario AND `pass` = :contrasena LIMIT 1;");
        $stmt = $conn->prepare(" SELECT `id`,`nombre`, `apodo`, `pass`, `email`, `nivel`, `creado`, CASE `nivel`  WHEN 1 THEN 'admin'  WHEN 2 THEN 'mozo'  ELSE 'desconocido'    END AS nivel_usuario  FROM `user` WHERE `email` = :usuario AND `pass` = :contrasena LIMIT 1;");
        $stmt->bindParam(':usuario', $_POST['user']);
        $stmt->bindParam(':contrasena', $_POST['pass']);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            $stmt = $conn->prepare("INSERT INTO `user_control` (`id`, `tipo`, `user`) VALUES (NULL, '1',?);");
            $_SESSION['usuario'] = $user;
            $stmt->execute([$_SESSION['usuario']['id']]);
            //    header('Location: ../../../V1/ADMIN/');
        } else {
            $stmt = $conn->prepare("INSERT INTO `user_control` (`id`, `tipo`, `user`) VALUES (NULL, '6',?);");
            $stmt->execute([5]);
        }
        header('Location: ./');
    }
    public  function logoutUser($conn)
    {
        $stmt = $conn->prepare("INSERT INTO `user_control` (`id`, `tipo`, `user`) VALUES (NULL, '0',?);");
        $stmt->execute([$_SESSION['admin']['id']]);
        $_SESSION = null;
        session_destroy();
        header('Location: ./');
    }
}
