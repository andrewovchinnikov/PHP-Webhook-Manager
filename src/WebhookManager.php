<?php

declare(strict_types=1);

namespace WebhookManager;

class WebhookManager
{
    private array                  $handlers = [];
    private WebhookClientInterface $client;
    private WebhookAuthentication  $authentication;
    private WebhookLogger          $logger;

    public function __construct(WebhookClientInterface $client, WebhookAuthentication $authentication, WebhookLogger $logger = null)
    {
        $this->client         = $client;
        $this->authentication = $authentication;
        $this->logger         = $logger;
    }

    public function registerHandler(string $eventName, WebhookHandlerInterface $handler) : void
    {
        $this->handlers[$eventName][] = $handler;
    }

    /**
     * @throws \Exception
     */
    public function triggerEvent(WebhookEvent $event): void
    {
        $this->logger->log(sprintf('Triggering event "%s"', $event->getName()));

        if (!$this->authentication->authenticate($event->getWebhook())) {
            $this->logger->log('Authentication failed');

            return;
        }

        foreach ($this->handlers[$event->getName()] as $handler) {
            $handler->handle($event);
        }

        try {
            $response = $this->client->send($event->getWebhook());
            $statusCode = $response->getStatusCode();
            $this->logger->log(sprintf('Event "%s" completed with response code %d', $event->getName(), $statusCode));
        } catch (WebhookDeliveryException $e) {
            $this->logger->log(sprintf('Error delivering webhook for event "%s": %s', $event->getName(), $e->getMessage()));
        }
    }
}
