<?php

declare(strict_types=1);

namespace WebhookManager;

class WebhookManager
{
    private array $handlers = [];
    private WebhookClient $client;

    public function __construct(WebhookClient $client)
    {
        $this->client = $client;
    }

    public function registerHandler(string $eventName, WebhookHandlerInterface $handler): void
    {
        $this->handlers[$eventName][] = $handler;
    }

    public function triggerEvent(WebhookEvent $event): void
    {
        if (!isset($this->handlers[$event->getName()])) {
            return;
        }

        foreach ($this->handlers[$event->getName()] as $handler) {
            $handler->handle($event);
        }

        $this->client->send($event->getWebhook());
    }
}
