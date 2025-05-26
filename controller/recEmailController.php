<?php

session_start();
require_once '../MODEL/recModelModel.php';
require_once '../MODEL/recSenhaModel.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    
    if($email && RecModelModel::verificarExistenciaEmail($email)) {

        RecModelModel::excluirCodigosAntigos($email);
        
        
        $codigo = strtoupper(bin2hex(random_bytes(3))); 
        if(RecSenhaModel::salvarCodigo($email, $codigo)) {

            error_log("Código enviado para $email: $codigo");
            $_SESSION['email_recuperacao'] = $email;
            header('Location: ../views/enviar_codigo.php');
            exit();
        }
    }
    $erro = "E-mail não cadastrado!";
}
require_once '../views/recuperar_senha.php';
?>