<?php

declare(strict_types=1);

namespace WebhookManager;

interface WebhookHandlerInterface
{
    public function handle(WebhookEvent $event) : void;
}