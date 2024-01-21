<?php

class Auth
{
    private int $user_id;

    public function __construct(private UserGateway $userGateway, private JWTCodec $codec)
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

    public function authenticateAccessToken(): bool
    {
        if (!preg_match("/^Bearer\s+(.*)$/", $_SERVER["HTTP_AUTHORIZATION"], $matches)) {
            http_response_code(400);
            echo json_encode(["message" => "incomplete authorization header"]);
            return false;
        }
        
        // $plain_text = base64_decode($matches[1], true);
        
        // if ($plain_text === false) {
        //     http_response_code(400);
        //     echo json_encode(["message" => "invalid authorization header"]);
        //     return false;
        // }
        
        // $data = json_decode($plain_text, true);
        
        // if ($data === null) {
        //     http_response_code(400);
        //     echo json_encode(["message" => "invalid JSON"]);
        //     return false;
        // }

        try {
            $data = $this->codec->decode($matches[1]);
        } catch (InvalidSignatureException) {
            http_response_code(401);
            echo json_encode(["message" => "invalid signature"]);
            return false;
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
            return false;
        }

        $this->user_id = $data["sub"];

        return true;
    }
}