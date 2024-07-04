<?php

declare(strict_types=1);

namespace WebhookManager;

class WebhookSignatureValidator implements WebhookValidatorInterface
{
    private string $secret;

    public function __construct(string $secret)
    {
        $this->secret = $secret;
    }

    public function validate(Webhook $webhook): bool
    {
        $signature = $webhook->getHeaders()['X-Signature'] ?? '';
        $computedSignature = hash_hmac('sha256', $webhook->getPayload(), $this->secret);

        return hash_equals($signature, $computedSignature);
    }
}