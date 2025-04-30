<?php
session_start();
require_once '../MODEL/usuarioModel.php';
require_once '../SERVICE/conexao.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['msg'] = "Método de requisição inválido!";
    $_SESSION['msg_type'] = "error";
    header('Location: ../VIEW/usuario.php');
    exit();
}


$nome = filter_input(INPUT_POST, 'fullName', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'yourEmail', FILTER_SANITIZE_EMAIL);
$senha = $_POST['password'];  
$confirmarSenha = $_POST['confirmPassword'];

if (empty($nome) || empty($email) || empty($senha) || empty($confirmarSenha)) {
    $_SESSION['msg'] = "Todos os campos devem ser preenchidos!";
    $_SESSION['msg_type'] = "error";
    header('Location: ../VIEW/usuario.php');
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['msg'] = "Por favor, insira seu email!";
    $_SESSION['msg_type'] = "error";
    header('Location: ../VIEW/usuario.php');
    exit();
}

if ($senha !== $confirmarSenha) {
    $_SESSION['msg'] = "As senhas não são iguais!";
    $_SESSION['msg_type'] = "error";
    header('Location: ../VIEW/usuario.php');
    exit();
}

if (strlen($senha) < 8 || !preg_match('/[A-Za-z]/', $senha) || !preg_match('/[0-9]/', $senha)) {
    $_SESSION['msg'] = "A senha deve ter no mínimo 6 caracteres, incluindo letras e números!";
    $_SESSION['msg_type'] = "error";
    header('Location: ../VIEW/usuario.php');
    exit();
}

try {
 
    if (Usuario::cadastrar($pdo, $nome, $email, $senha)) {
        $_SESSION['msg'] = "Usuario cadastrado com sucesso! Faça já seu login.";
        $_SESSION['msg_type'] = "success";
        header('Location: ../VIEW/login.php');
        exit();
    } else {
        throw new Exception("Falha ao cadastrar usuário. Tente novamente");
    }
} catch (Exception $e) {
    
    error_log("Registration error: " . $e->getMessage());
    
    $_SESSION['msg'] = "Erro ao registrar. O e-mail já está cadastrado?";
    $_SESSION['msg_type'] = "error";
    header('Location: ../VIEW/usuario.php');
    exit();
}