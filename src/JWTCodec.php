<?php

class JWTCodec
{
    public function encode(array $payload): string
    {
        $header = json_encode([
            "typ" => "JWT",
            "alg" => "HS256"
        ]);
        $header = $this->base64urlEncode($header);
        
        $payload = json_encode($payload);
        $payload = $this->base64urlEncode($payload);
        
        $signature = hash_hmac("sha256",
                               $header . "." . $payload,
                               "A2170FBC89499B0ADC84AFF2C4CF7DBECED5221BBE4B4EBF9AAE50FA67F8F4B7",
                               true);
        $signature = $this->base64urlEncode($signature);
        
        return $header . "." . $payload . "." . $signature;
    }
    
    private function base64urlEncode(string $text): string
    {
        return str_replace(
            ["+", "/", "="],
            ["-", "_", ""],
            base64_encode($text)
        );
    }
}
