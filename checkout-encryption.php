<?php

class Checkout {
    private $secret;
    private $IV;

    public function __construct($secret, $IV) {
        $this->secret = $secret;
        $this->IV = $IV;
    }

    public function encrypt($requestBody) {
        $secret = hash('sha256', $this->secret);
        $IV = substr(hash('sha256', $this->IV), 0, 16);

        $payload = json_encode($requestBody);
        $result = openssl_encrypt(
            $payload, 
            'AES-256-CBC', 
            $secret, 
            0, 
            $IV
        );

        return base64_encode($result);
    }
}
