<?php

declare(strict_types=1);

namespace WebhookManager;

class SimpleWebhookLogger implements WebhookLogger
{
    public function log(string $message) : void
    {
        error_log($message);
    }
}