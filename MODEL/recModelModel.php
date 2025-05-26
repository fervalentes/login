<?php
require_once 'funcao.php';

class RecModelModel {
    public static function verificarExistenciaEmail($email) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT email FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function excluirCodigosAntigos($email) {
        $db = Database::connect();
        $stmt = $db->prepare("DELETE FROM recuperacao WHERE email = ?");
        return $stmt->execute([$email]);
    }
}
?>