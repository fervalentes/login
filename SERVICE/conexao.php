<?php
class Database {
    protected static $db;

    public static function connect() {
        if (!self::$db) {
            try {
                self::$db = new PDO('sqlite:database.db');
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::createTables();
            } catch (PDOException $e) {
                die("Erro de conexão: " . $e->getMessage());
            }
        }
        return self::$db;
    }

    private static function createTables() {
        self::$db->exec("CREATE TABLE IF NOT EXISTS usuarios (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nome TEXT NOT NULL,
            email TEXT UNIQUE NOT NULL,
            senha TEXT NOT NULL
        )");

        self::$db->exec("CREATE TABLE IF NOT EXISTS recuperacao (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            email TEXT NOT NULL,
            codigo TEXT NOT NULL,
            expiracao DATETIME NOT NULL
        )");

        self::$db->exec("CREATE TABLE IF NOT EXISTS emails (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            usuario TEXT NOT NULL,
            code TEXT NOT NULL,
            lido INTEGER DEFAULT 0
        )");
    }
}
?>
