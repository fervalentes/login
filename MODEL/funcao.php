<?php
class Database {
    private static $db = null;

    public static function connect() {
        if (!self::$db) {
            try {
                $host = '127.0.0.1';   
                $dbname = 'login';    
                $user = 'root';      
                $pass = '';            

                $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
                self::$db = new PDO($dsn, $user, $pass);
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $e) {
                die("Erro na conexão com banco MySQL: " . $e->getMessage());
            }
        }
        return self::$db;
    }
}
?>
