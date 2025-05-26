<?php
require_once 'funcao.php';

class RecSenhaModel {
    public static function salvarCodigo($email, $codigo) {
        $db = Database::connect();
        $expiracao = date('Y-m-d H:i:s', strtotime('+15 minutes'));
        $stmt = $db->prepare("INSERT INTO recuperacao (email, codigo, expiracao) VALUES (?, ?, ?)");
        return $stmt->execute([$email, $codigo, $expiracao]);
    }
}
?>