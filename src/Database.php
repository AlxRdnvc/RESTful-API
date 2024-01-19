<?php

class Database 
{
    private string $host;
    private string $dbname;
    private string $user;
    private string $pass;

    public function __construct(string $host, string $dbname, string $user, string $pass)
    {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->user = $user;
        $this->pass = $pass;

    }

    public function getConnection()
    {
        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8";

        return new PDO($dsn, $this->user, $this->pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); 
    }
}