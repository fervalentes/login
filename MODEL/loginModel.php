<?php
require '../SERVICE/conexao.php';

function register(string $email, string $password): bool {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new InvalidArgumentException("Email inválido");
    }

    if (strlen($password) < 8) {
        throw new InvalidArgumentException("Senha deve ter no mínimo 8 caracteres");
    }

    try {
        $pdo = Database::getInstance();

        $stmt = $pdo->prepare("SELECT id FROM pessoa WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            throw new Exception("Email já cadastrado");
        }

        $pdo->beginTransaction();

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO pessoa (email, senha) VALUES (?, ?)");
        $stmt->execute([$email, $hashedPassword]);

        $pdo->commit();
        return true;
    } catch (PDOException $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        error_log("Erro no registro: " . $e->getMessage());
        throw new Exception("Falha ao registrar usuário");
    }
}
?>