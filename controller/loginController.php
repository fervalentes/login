<?php
session_start();
require_once '../MODEL/loginModel.php';
require_once '../SERVICE/conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $_SESSION['msg'] = "Por favor, preencha todos os campos.";
        $_SESSION['msg_tipo'] = "erro";
        header('Location: ../VIEW/login.php');
        exit();
    }

    
    $email = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['password'];

    try {
        $usuario = Usuario::buscarPorEmail($pdo, $email);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            
            $_SESSION['usuario'] = [
                'id' => $usuario['id'],
                'nome' => $usuario['nome'],
                'email' => $usuario['email']
            ];
            
            
            session_regenerate_id(true);
            
            $_SESSION['msg'] = "Login realizado com sucesso!";
            $_SESSION['msg_tipo'] = "sucesso";
            exit();
        } else {
        
            $_SESSION['msg'] = "Credenciais inválidas.";
            $_SESSION['msg_tipo'] = "erro";
            header('Location: ../VIEW/login.php');
            exit();
        }
    } catch (Exception $e) {
     
        error_log("Erro no login: " . $e->getMessage());
        
        $_SESSION['msg'] = "Ocorreu um erro durante o login. Tente novamente.";
        $_SESSION['msg_tipo'] = "erro";
        header('Location: ../VIEW/login.php');
        exit();
    }
} else {
   
    header('Location: ../VIEW/login.php');
    exit();
}
?>