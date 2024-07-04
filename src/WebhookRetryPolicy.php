<?php

declare(strict_types=1);

namespace WebhookManager;

interface WebhookRetryPolicy
{
    public function shouldRetry(Webhook $webhook, \Exception $exception) : bool;
}
