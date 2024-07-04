<?php

namespace WebhookManager;

class ExampleWebhookHandler implements WebhookHandlerInterface
{
    public function handle(WebhookEvent $event) : void
    {
        // Здесь вы можете добавить свой код для обработки события веб-хука
        echo sprintf('Received event "%s" with webhook: %s', $event->getName(), json_encode($event->getWebhook()->getHeaders()));
    }
}
