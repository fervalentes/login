<?php
session_start();
require_once '../MODEL/codigoModel.php';
require_once '../SERVICE/conexao.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['msg'] = "Método de requisição inválido!";
    $_SESSION['msg_type'] = "error";
    header('Location: ../VIEW/recuperaçãosenha.php');
    exit();
}


$email = $_SESSION['email_recuperacao'] ?? null;
if (!$email) {
    $_SESSION['msg'] = "Sessão expirada . Por favor, inicie novamente.";
    $_SESSION['msg_type'] = "error";
    header('Location: ../VIEW/recuperaçãosenha.php');
    exit();
}


$codigo = filter_input(INPUT_POST, 'codigo', FILTER_SANITIZE_NUMBER_INT);
if (empty($codigo) || strlen($codigo) !== 4) {
    $_SESSION['msg'] = "Código inválido! Deve conter 4 dígitos.";
    $_SESSION['msg_type'] = "error";
    header('Location: ../VIEW/codigo.php');
    exit();
}

try {
    if (!empty($_SESSION['codigo_tentativas']) && $_SESSION['codigo_tentativas'] >= 3) {
        $_SESSION['msg'] = "Muitas tentativas incorretas. Solicite um novo código.";
        $_SESSION['msg_type'] = "error";
        header('Location: ../VIEW/recuperaçãosenha.php');
        exit();
    }

    if (!empty($_SESSION['codigo_expira']) && time() > $_SESSION['codigo_expira']) {
        $_SESSION['msg'] = "Código expirado! Solicite um novo.";
        $_SESSION['msg_type'] = "error";
        header('Location: ../VIEW/recuperaçãosenha.php');
        exit();
    }

    if (Codigo::verificarCodigo($pdo, $email, $codigo)) {
  
        unset($_SESSION['codigo_tentativas']);
        
        $_SESSION['msg'] = "Código verificado com sucesso!";
        $_SESSION['msg_type'] = "success";
        $_SESSION['codigo_validado'] = true; 
        header('Location: ../VIEW/senha.php');
        exit();
    } else {
        
        $_SESSION['codigo_tentativas'] = ($_SESSION['codigo_tentativas'] ?? 0) + 1;
        
        $remaining_attempts = 3 - $_SESSION['codigo_tentativas'];
        $_SESSION['msg'] = "Código inválido! Tentativas restantes: " . $remaining_attempts;
        $_SESSION['msg_type'] = "error";
        header('Location: ../VIEW/codigo.php');
        exit();
    }
} catch (Exception $e) {
    error_log("Code verification error: " . $e->getMessage());
    
    $_SESSION['msg'] = "Ocorreu um erro ao verificar o código. Tente novamente.";
    $_SESSION['msg_type'] = "error";
    header('Location: ../VIEW/codigo.php');
    exit();
}