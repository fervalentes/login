<?php
class conexao {
    private $host = 'localhost';
    private $db = 'login';
    private $user = 'root';
    private $pass = '';
    private $instance;

    public function __construct() {
        try {
            $this->instance = new PDO("mysql:host=$this->host;dbname=$this->db;charset=utf8", $this->user, $this->pass);
            $this->instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro na conexão: " . $e->getMessage());
        }
    }

    public function getInstanse() {
        return $this->instance;
    }
}
