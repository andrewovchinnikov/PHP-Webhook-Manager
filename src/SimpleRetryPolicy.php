<?php

declare(strict_types=1);

namespace WebhookManager;

class SimpleRetryPolicy implements WebhookRetryPolicy
{
    private int $maxAttempts;

    public function __construct(int $maxAttempts)
    {
        $this->maxAttempts = $maxAttempts;
    }

    public function shouldRetry(Webhook $webhook, \Exception $exception): bool
    {
        $attempts = $webhook->getAttempts() ?? 0;

        return $attempts < $this->maxAttempts;
    }
}
