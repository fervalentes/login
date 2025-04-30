<?php

class usePDO
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "login";
    private $instance;
    
    function getInstanse()
    {
        if (empty($this->instanse)){
            $this->instance = $this->connection();
        }
        return $this->instance;
    }
    
    private function connection()
    {
        try{
            $conn = new PDO ("mysql:host=$this->servername; dbname=$this->dbname", $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PODException $e){
            die("Connection failed:" . $e->getMessage() . "<br>");
        }
    }
}

$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "login";

$conexao = new mysqli($servidor, $usuario, $senha, $banco);

if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

$conexao->set_charset("utf8");
?>