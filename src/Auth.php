<?php

class Auth
{
    private int $user_id;

    public function __construct(private UserGateway $userGateway)
    {   
    }

    public function authenticateAPIKey(): bool
    {
        if (empty($_SERVER["HTTP_X_API_KEY"])) {   
            http_response_code(400);
            echo json_encode(["message" => "missing API key"]);
            return false;
        }
        
        $apiKey = $_SERVER["HTTP_X_API_KEY"];  
        $user = $this->userGateway->getByAPIKey($apiKey);
        
        if ($user === false) {     
            http_response_code(401);
            echo json_encode(["message" => "invalid API key"]);
            return false;
        }          
        
        $this->user_id = $user["id"];
        
        return true;  
    }

    public function getuser_id(): int
    {
        return $this->user_id;
    }
}