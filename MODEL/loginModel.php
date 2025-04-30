<?php
require '../SERVICE/conexao.php';

function register($email, $password) {

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new InvalidArgumentException("Email inválido");
    }
    
    if (strlen($password) < 8) {
        throw new InvalidArgumentException("Senha deve ter no mínimo 8 caracteres");
    }

    try {
        $conn = new Database();
        $instance = $conn->getInstance();
        
      
        $stmt = $instance->prepare("SELECT id FROM pessoa WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->fetch()) {
            throw new Exception("Email já cadastrado");
        }

     
        $instance->beginTransaction();

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $instance->prepare(
            "INSERT INTO pessoa(email, senha) VALUES (?, ?)"
        );
        $stmt->execute([$email, $hashed_password]);
        $instance->commit();
        
        return true;
    } catch (PDOException $e) {
       
        if (isset($instance) && $instance->inTransaction()) {
            $instance->rollBack();
        }
        error_log("Erro no registro: " . $e->getMessage());
        throw new Exception("Falha ao registrar usuário");
    }
}