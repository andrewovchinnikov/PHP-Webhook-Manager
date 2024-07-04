<?php

namespace WebhookManager;

use WebhookManager\WebhookAuthentication;

class SecretKeyAuthentication implements WebhookAuthentication
{
    private string $secretKey;

    public function __construct(string $secretKey)
    {
        $this->secretKey = $secretKey;
    }

    public function authenticate(Webhook $webhook) : bool
    {
        $signature         = hash_hmac('sha256', $webhook->getPayload(), $this->secretKey);
        $expectedSignature = $webhook->getHeaders()['X-Signature'] ?? '';

        return hash_equals($signature, $expectedSignature);
    }
}