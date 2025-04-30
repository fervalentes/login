<?php
session_start();
require_once '../MODEL/UsuarioModel.php';
require_once '../SERVICE/conexao.php';

// Conexão com o banco (ajuste conforme sua classe)
$pdo = (new usePDO())->getInstanse();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Validação dos campos
        if (empty($_POST['username']) || empty($_POST['password'])) {
            throw new Exception("Por favor, preencha todos os campos");
        }

        // Sanitização
        $email = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_EMAIL);
        $senha = $_POST['password'];

        // Validação do email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Formato de e-mail inválido");
        }

        // Verifica credenciais
        $usuario = Usuario::buscarPorEmail($pdo, $email);
        
        if (!$usuario || !password_verify($senha, $usuario['senha'])) {
            throw new Exception("E-mail ou senha incorretos");
        }

        // Configura a sessão
        $_SESSION['usuario'] = [
            'id' => $usuario['id'],
            'nome' => $usuario['nome'],
            'email' => $usuario['email']
        ];
        
        // Proteção contra session fixation
        session_regenerate_id(true);
        
        // Redireciona para a página inicial na pasta VIEW
        header('Location: ../VIEW/INICIAL.PHP');
        exit();

    } catch (Exception $e) {
        $_SESSION['msg'] = $e->getMessage();
        $_SESSION['msg_tipo'] = "erro";
        header('Location: ../VIEW/login.php');
        exit();
    }
} else {
    // Se acessado diretamente sem POST
    header('Location: ../VIEW/login.php');
    exit();
}
?>