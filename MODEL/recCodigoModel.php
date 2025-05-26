<?php
class RecCodigoModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

   
    public function salvarCodigo($email, $codigo) {
        $stmt = $this->pdo->prepare("
            INSERT INTO codigo_verificacao (email, numero_codigo, usuario_id) 
            VALUES (?, ?, (SELECT id_pessoa FROM pessoa WHERE email = ?))
        ");
        return $stmt->execute([$email, $codigo, $email]);
    }

    public function verificarCodigo($email, $codigo) {
        $stmt = $this->pdo->prepare("
            SELECT * FROM codigo_verificacao 
            WHERE email = ? AND numero_codigo = ? 
            AND usado = 0
        ");
        $stmt->execute([$email, $codigo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function invalidarCodigo($id_codigo) {
        $stmt = $this->pdo->prepare("
            UPDATE codigo_verificacao SET usado = 1 WHERE id_codigo = ?
        ");
        return $stmt->execute([$id_codigo]);
    }
}