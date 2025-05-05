<?php

class Database {
    private static $instance = null;

    public static function getInstance() {
        if (self::$instance === null) {
            try {
                self::$instance = new PDO("mysql:host=localhost;dbname=login", "root", "");
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->exec("SET NAMES utf8");
            } catch (PDOException $e) {
                die("Erro na conexão: " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
?>