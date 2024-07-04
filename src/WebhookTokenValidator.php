<?php

declare(strict_types=1);

namespace WebhookManager;

class WebhookTokenValidator
{
    private string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function validate(Webhook $webhook): bool
    {
        $token = $webhook->getHeaders()['X-Token'] ?? '';

        return hash_equals($token, $this->token);
    }
}