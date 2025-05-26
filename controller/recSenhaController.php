<?php
require_once '../MODEL/recSenhaModel.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    
    if($email) {
        $codigo = bin2hex(random_bytes(3));
        if(RecSenhaModel::salvarCodigo($email, $codigo)) {
            
            header('Location: enviar_codigo.php');
            exit();
        }
    }
    $erro = "E-mail inválido!";
}
require_once '../views/recuperar_senha.php';
?>