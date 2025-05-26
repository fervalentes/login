<?php
require_once 'funcao.php';

class CadastroModel {
    public static function cadastrar($nome, $email, $senha) {
        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO usuario (nome, email, senha) VALUES (?, ?, ?)");
        return $stmt->execute([$nome, $email, password_hash($senha, PASSWORD_DEFAULT)]);
    }
}
        $stmt = $db->prepare("SELECT COUNT(*) FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetchColumn() > 0) {
            return false;
        }

        $stmt = $db->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
        return $stmt->execute([$nome, $email, password_hash($senha, PASSWORD_DEFAULT)]);
    
?>
