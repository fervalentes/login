<?php
session_start();
require_once '../MODEL/UsuarioModel.php';
require_once '../SERVICE/conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Validação dos campos
        if (empty($_POST['username']) || empty($_POST['password'])) {
            throw new Exception("Por favor, preencha todos os campos");
        }

        // Sanitização
        $email = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_EMAIL);
        $senha = $_POST['password'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Formato de e-mail inválido");
        }

        // Busca usuário
        $usuario = Usuario::buscarPorEmail($pdo, $email);

        if (!$usuario || !password_verify($senha, $usuario['senha'])) {
            throw new Exception("Credenciais inválidas");
        }

        // Configura a sessão
        $_SESSION['usuario'] = [
            'id' => $usuario['id'],
            'nome' => $usuario['nome'],
            'email' => $usuario['email']
        ];
        
        // Proteção contra fixation de sessão
        session_regenerate_id(true);
        
        // Mensagem de sucesso
        $_SESSION['msg'] = "Login realizado com sucesso!";
        $_SESSION['msg_tipo'] = "sucesso";
        
        // Redireciona para página inicial
        header('Location: ../VIEW/pagina_inicial.php');
        exit();

    } catch (Exception $e) {
        // Mensagem de erro
        $_SESSION['msg'] = $e->getMessage();
        $_SESSION['msg_tipo'] = "erro";
        
        // Redireciona de volta ao login
        header('Location: ../VIEW/login.php');
        exit();
    }
} else {
    // Se acessado diretamente sem POST
    header('Location: ../VIEW/login.php');
    exit();
}
?>