<?php

class UserGateway
{
    private PDO $conn;
    
    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }
    
    public function getByAPIKey(string $key): array | false
    {
        $query = "SELECT *
                FROM user
                WHERE api_key = :api_key";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":api_key", $key, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    public function getByUsername(string $username): array | false
    {
        $query = "SELECT *
                FROM user
                WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":username", $username, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByID(int $id): array | false
    {
        $query = "SELECT *
                FROM user
                WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
