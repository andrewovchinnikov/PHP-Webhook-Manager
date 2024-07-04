<?php

declare(strict_types=1);

namespace WebhookManager;

interface WebhookLogger
{
    public function log(string $message): void;
}
