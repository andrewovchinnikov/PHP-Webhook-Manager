<?php

declare(strict_types=1);

namespace WebhookManager;

use Psr\Http\Message\ResponseInterface;

interface WebhookClientInterface
{
    public function send(Webhook $webhook): ResponseInterface;
}
