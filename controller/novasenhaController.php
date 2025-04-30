<?php
session_start();
require_once '../MODEL/usuarioModel.php';
require_once '../SERVICE/conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
    $email = $_SESSION['email_recuperacao'] ?? null;
    
    if (!$email) {
        $_SESSION['msg'] = "Sessão expirada! Por favor, tente novamente.";
        $_SESSION['msg_tipo'] = "erro";
        header('Location: ../VIEW/recuperaçãosenha.php');
        exit();
    }

   
    $novaSenha = $_POST['nova_senha'] ?? '';
    $confirmarSenha = $_POST['confirmar_senha'] ?? '';

  
    if (strlen($novaSenha) < 8) {
        $_SESSION['msg'] = "A senha deve ter no mínimo 6 caracteres!";
        $_SESSION['msg_tipo'] = "erro";
        header('Location: ../VIEW/senha.php');
        exit();
    }

    if ($novaSenha !== $confirmarSenha) {
        $_SESSION['msg'] = "As senhas não coincidem!";
        $_SESSION['msg_tipo'] = "erro";
        header('Location: ../VIEW/senha.php');
        exit();
    }

    try {
        
        if (Usuario::alterarSenha($pdo, $email, $novaSenha)) {
            
            unset($_SESSION['email_recuperacao']);
            unset($_SESSION['token_recuperacao']);
            
            $_SESSION['msg'] = "Senha alterada com sucesso! Faça login com sua nova senha.";
            $_SESSION['msg_tipo'] = "sucesso";
            header('Location: ../VIEW/login.php');
            exit();
        } else {
            throw new Exception("Falha ao atualizar a senha no banco de dados");
        }
    } catch (Exception $e) {
    
        error_log("Erro ao alterar senha: " . $e->getMessage());
        
        $_SESSION['msg'] = "Ocorreu um erro ao alterar sua senha. Tente novamente.";
        $_SESSION['msg_tipo'] = "erro";
        header('Location: ../VIEW/senha.php');
        exit();
    }
} else {
    
    $_SESSION['msg'] = "Método de requisição inválido!";
    $_SESSION['msg_tipo'] = "erro";
    header('Location: ../VIEW/recuperaçãosenha.php');
    exit();
}
?>