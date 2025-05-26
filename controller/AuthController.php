<?php
session_start();
require_once '../MODEL/authModel.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $senha = $_POST['senha'];

    if($usuario = AuthModel::autenticar($email, $senha)) {
        $_SESSION['usuario'] = $usuario['nome'];
        header('Location: ../views/welcome.php');
        exit();
    }
    $erro = "Credenciais inválidas!";
}
require_once '../views/login.php';
?>