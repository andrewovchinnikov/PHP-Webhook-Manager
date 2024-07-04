<?php

declare(strict_types=1);

namespace WebhookManager;

use Firebase\JWT\JWT;

class JwtAuthentication implements WebhookAuthentication
{
    private string $secretKey;

    public function __construct(string $secretKey)
    {
        $this->secretKey = $secretKey;
    }

    public function authenticate(Webhook $webhook) : bool
    {
        try {
            $token   = $webhook->getHeaders()['Authorization'] ?? '';
            $decoded = JWT::decode($token, $this->secretKey, ['HS256']);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}