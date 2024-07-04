<?php

namespace WebhookManager;

class WebhookEvent
{
    private string  $name;
    private Webhook $webhook;

    public function __construct(string $name, Webhook $webhook)
    {
        $this->name    = $name;
        $this->webhook = $webhook;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getWebhook() : Webhook
    {
        return $this->webhook;
    }
}