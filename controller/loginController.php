<?php
session_start();
require_once '../MODEL/UsuarioModel.php'; // Verifique se o nome do arquivo está correto
require_once '../SERVICE/conexao.php';

// Verifique se a conexão está sendo criada corretamente
$pdo = (new Conexao())->getInstance(); // Adapte conforme sua classe de conexão

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Verifica campos vazios
        if (empty($_POST['username']) || empty($_POST['password'])) {
            throw new Exception("Por favor, preencha todos os campos");
        }

        // Sanitização
        $email = filter_var($_POST['username'], FILTER_SANITIZE_EMAIL);
        $senha = $_POST['password'];

        // Verifica formato do email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Formato de e-mail inválido");
        }

        // Busca usuário - VERIFIQUE se o método existe no Model
        $usuario = Usuario::buscarPorEmail($pdo, $email);

        if (!$usuario || !password_verify($senha, $usuario['senha'])) {
            throw new Exception("E-mail ou senha incorretos");
        }

        // Configura sessão
        $_SESSION['usuario'] = [
            'id' => $usuario['id'],
            'nome' => $usuario['nome'],
            'email' => $usuario['email']
        ];
        
        session_regenerate_id(true);
        
        $_SESSION['msg'] = "Login realizado com sucesso!";
        $_SESSION['msg_tipo'] = "sucesso";
        header('Location: ../VIEW/pagina_inicial.php');
        exit();

    } catch (Exception $e) {
        $_SESSION['msg'] = $e->getMessage();
        $_SESSION['msg_tipo'] = "erro";
        header('Location: ../VIEW/login.php');
        exit();
    }
} else {
    header('Location: ../VIEW/login.php');
    exit();
}
?>