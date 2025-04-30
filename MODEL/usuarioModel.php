<?php
declare(strict_types=1);

final class Usuario
{
    private function __construct() {} 
    public static function buscarPorEmail(
        PDO $pdo,
        string $email,
        array $columns = ['*']
    ): ?array {
        self::validateEmail($email);
        
        $columns = implode(', ', array_map([$pdo, 'quote'], $columns));
        $stmt = $pdo->prepare("SELECT {$columns} FROM usuarios WHERE email = :email LIMIT 1");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public static function cadastrar(
        PDO $pdo,
        string $nome,
        string $email,
        string $senha
    ): bool {
        self::validateCredentials($nome, $email, $senha);
        
        try {
            $pdo->beginTransaction();
            
            if (self::buscarPorEmail($pdo, $email)) {
                throw new RuntimeException('Email já cadastrado');
            }
            
            $stmt = $pdo->prepare(
                "INSERT INTO usuarios (nome, email, senha, criado_em) 
                 VALUES (:nome, :email, :senha, NOW())"
            );
            
            $result = $stmt->execute([
                ':nome' => htmlspecialchars($nome, ENT_QUOTES, 'UTF-8'),
                ':email' => $email,
                ':senha' => self::hashPassword($senha)
            ]);
            
            $pdo->commit();
            return $result;
            
        } catch (Exception $e) {
            $pdo->rollBack();
            error_log("Registration failed: " . $e->getMessage());
            return false;
        }
    }

   
    public static function alterarSenha(
        PDO $pdo,
        string $email,
        string $novaSenha
    ): bool {
        self::validatePassword($novaSenha);
        
        $stmt = $pdo->prepare(
            "UPDATE usuarios 
             SET senha = :senha, atualizado_em = NOW() 
             WHERE email = :email"
        );
        
        return $stmt->execute([
            ':senha' => self::hashPassword($novaSenha),
            ':email' => $email
        ]);
    }

    private static function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    private static function validateEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Email inválido');
        }
    }

    private static function validatePassword(string $password): void
    {
        if (strlen($password) < 8) {
            throw new InvalidArgumentException('Senha deve ter pelo menos 8 caracteres');
        }
    }

    private static function validateCredentials(
        string $nome,
        string $email,
        string $senha
    ): void {
        self::validateEmail($email);
        self::validatePassword($senha);
        
        if (empty(trim($nome))) {
            throw new InvalidArgumentException('Nome não pode estar vazio');
        }
    }
}