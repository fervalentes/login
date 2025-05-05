<?php
session_start();
require_once '../MODEL/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];

    $usuario = Usuario::buscarPorEmail($email); // Note: capital "U"

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario'] = $usuario;
        header('Location: ../VIEW/inicial.php');
    } else {
        $_SESSION['msg'] = "Credenciais inválidas!";
        header('Location: ../VIEW/login.php');
    }
    exit();
}
?>
