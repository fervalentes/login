<?php
session_start();
require_once '../MODEL/UsuarioModel.php';
require_once '../SERVICE/conexao.php';

// Debug: Mostra todos os erros
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conexão PDO
$pdo = (new usePDO())->getInstanse();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Verifica campos vazios
        if (empty($_POST['username']) || empty($_POST['password'])) {
            throw new Exception("Por favor, preencha todos os campos");
        }

        $email = filter_var($_POST['username'], FILTER_SANITIZE_EMAIL);
        $senha = $_POST['password'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Formato de e-mail inválido");
        }

        $usuario = Usuario::buscarPorEmail($pdo, $email);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario'] = [
                'id' => $usuario['id'],
                'nome' => $usuario['nome'],
                'email' => $usuario['email']
            ];
            
            session_regenerate_id(true);
            
            // DEBUG: Verifica se a sessão está sendo setada
            $_SESSION['debug'] = "Sessão criada com sucesso!";
            
            // Redirecionamento ABSOLUTO recomendado
            $base_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
            $redirect_url = $base_url . "../VIEW/INICIAL.PHP";
            
            // DEBUG: Mostra a URL de redirecionamento
            echo "Redirecionando para: " . $redirect_url;
            // header("Location: " . $redirect_url);
            exit();
        } else {
            throw new Exception("Credenciais inválidas");
        }
    } catch (Exception $e) {
        $_SESSION['msg'] = $e->getMessage();
        $_SESSION['msg_tipo'] = "erro";
        header('Location: /LOGIN/VIEW/login.php');
        exit();
    }
} else {
    header('Location: /Login/VIEW/login.php');
    exit();
}
?>