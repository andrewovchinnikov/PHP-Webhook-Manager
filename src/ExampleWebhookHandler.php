<?php

declare(strict_types=1);

namespace WebhookManager;

class ExampleWebhookHandler implements WebhookHandlerInterface
{
    public function handle(WebhookEvent $event) : void
    {
        // Здесь вы можете добавить свой код для обработки события веб-хука
        echo sprintf('Received event "%s" with data: %s', $event->getName(), $event->getWebhook()->getPayload());
    }
}
