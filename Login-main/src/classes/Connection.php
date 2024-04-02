<?php
// Connection.php

namespace Login\classes;

class Connection
{
    private $host = "localhost";
    private $dbname = "login";
    private $name = "root";
    private $pass = "";
    private $pdo;

    public function __construct()
    {
        try 
        {
            $this->pdo = new \PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->name, $this->pass);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } 
        catch (\PDOException $e) 
        {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getPdo()
    {
        return $this->pdo;
    }
}