<?php

declare(strict_types=1);

namespace WebhookManager;

class WebhookManager
{
    private array $handlers = [];
    private WebhookClient $client;
    private WebhookAuthentication $authentication;

    public function __construct(WebhookClient $client, WebhookAuthentication $authentication)
    {
        $this->client = $client;
        $this->authentication = $authentication;
    }

    public function registerHandler(string $eventName, WebhookHandlerInterface $handler): void
    {
        $this->handlers[$eventName][] = $handler;
    }

    public function triggerEvent(WebhookEvent $event): void
    {
        if (!$this->authentication->authenticate($event->getWebhook())) {
            throw new \RuntimeException('Webhook authentication failed');
        }

        foreach ($this->handlers[$event->getName()] as $handler) {
            $handler->handle($event);
        }

        $this->client->send($event->getWebhook());
    }
}
