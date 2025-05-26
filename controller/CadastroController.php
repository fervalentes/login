<?php
session_start();
require_once '../MODEL/cadastroModel.php';

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
    $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
    $nome = trim($firstname . ' ' . $lastname);

    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $senha = $_POST['password'] ?? '';
    $confSenha = $_POST['confirmpassword'] ?? ''; 

    if (!$nome || !$email) {
        $mensagem = "Nome ou email inválido!";
    } elseif (strlen($senha) < 6) {
        $mensagem = "Senha deve ter pelo menos 6 caracteres.";
    } elseif ($senha !== $confSenha) {
        $mensagem = "Senha e confirmação não conferem.";
    } else {
       if (CadastroModel::cadastrar($nome, $email, $senha)) {
    $mensagem = "Cadastro realizado com sucesso!";
} else {
    $mensagem = "Erro: este email já está cadastrado ou ocorreu um erro.";
}
    }

}

require_once '../VIEW/cadastro.php';
?>
