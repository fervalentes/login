<?php
require_once 'funcao.php';

class AuthModel {
    public static function autenticar($email, $senha) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return ($usuario && password_verify($senha, $usuario['senha'])) ? $usuario : false;
    }
}
?>