<?php

declare(strict_types=1);

namespace WebhookManager;

interface WebhookAuthentication
{
    public function authenticate(Webhook $webhook) : bool;
}