<?php
session_start();
require_once '../MODEL/recSenhaModel.php';

if(!isset($_SESSION['email_recuperacao'])) {
    header('Location: ../views/recuperar_senha.php');
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigoDigitado = strtoupper($_POST['codigo']);
    $email = $_SESSION['email_recuperacao'];
    
    $db = Database::connect();
    $stmt = $db->prepare("SELECT codigo FROM recuperacao WHERE email = ? AND expiracao > datetime('now')");
    $stmt->execute([$email]);
    $codigoValido = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($codigoValido && $codigoDigitado === $codigoValido['codigo']) {
        header('Location: ../views/redefinir_senha.php');
        exit();
    }
    $erro = "Código inválido ou expirado!";
}
require_once '../views/enviar_codigo.php';
?>