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