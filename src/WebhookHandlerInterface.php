<?php

namespace WebhookManager;

interface WebhookHandlerInterface
{
    public function handle(WebhookEvent $event) : void;
}