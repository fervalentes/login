<?php
session_start();
require_once '../MODEL/codigoModel.php';
require_once '../MODEL/usuarioModel.php';
require_once '../SERVICE/conexao.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    $_SESSION['msg'] = "Requisição inválida!";
    $_SESSION['msg_tipo'] = "erro";
    header('Location: ../VIEW/recuperaçãosenha.php');
    exit();
}


$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['msg'] = "Por favor, seu email!";
    $_SESSION['msg_tipo'] = "erro";
    header('Location: ../VIEW/recuperaçãosenha.php');
    exit();
}

try {
  
    $usuario = Usuario::buscarPorEmail($pdo, $email);

    if (!$usuario) {
        
        $_SESSION['msg'] = "Se o e-mail estiver cadastrado, você irá receber um código de recuperação.";
        $_SESSION['msg_tipo'] = "info";
        header('Location: ../VIEW/recuperaçãosenha.php');
        exit();
    }

 
    $codigo = random_int(1000, 9999);
    
    
    if (!Codigo::salvarCodigo($pdo, $email, $codigo)) {
        throw new Exception("Falha ao salvar o código de recuperação");
    }

    
    $_SESSION['email_recuperacao'] = $email;
    $_SESSION['codigo_tentativas'] = 0;
    $_SESSION['codigo_expira'] = time() + 3600;
    
    $_SESSION['msg'] = "Foi enviado um código de verificação no seu email!";
    $_SESSION['msg_tipo'] = "sucesso";
    header('Location: ../VIEW/recuperaçãosenha.php');
    exit();

} catch (Exception $e) {
    
    error_log("Erro na recuperação de senha: " . $e->getMessage());
    
    $_SESSION['msg'] = "Ocorreu um erro. Tente novamente.";
    $_SESSION['msg_tipo'] = "erro";
    header('Location: ../VIEW/recuperaçãosenha.php');
    exit();
}
?>