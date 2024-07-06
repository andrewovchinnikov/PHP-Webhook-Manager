<?php

declare(strict_types=1);

namespace WebhookManager;

use Exception;

/**
 * Class WebhookManager
 *
 * This class manages the registration and triggering of webhook events.
 */
class WebhookManager
{
    /**
     * @var array An array of registered handlers for each event name.
     */
    private array $handlers = [];

    /**
     * @var WebhookClientInterface The webhook client used to send requests.
     */
    private WebhookClientInterface $client;

    /**
     * @var WebhookAuthentication The authentication mechanism used for webhook requests.
     */
    private WebhookAuthentication $authentication;

    /**
     * @var WebhookLogger The logger used to log webhook events.
     */
    private WebhookLogger $logger;

    /**
     * WebhookManager constructor.
     *
     * @param WebhookClientInterface $client         The webhook client used to send requests.
     * @param WebhookAuthentication  $authentication The authentication mechanism used for webhook requests.
     * @param WebhookLogger|null     $logger         The logger used to log webhook events.
     */
    public function __construct(WebhookClientInterface $client, WebhookAuthentication $authentication, WebhookLogger $logger = null)
    {
        $this->client         = $client;
        $this->authentication = $authentication;
        $this->logger         = $logger;
    }

    /**
     * Registers a handler for a specific event name.
     *
     * @param string                     $eventName      The name of the event to register the handler for.
     * @param WebhookHandlerInterface    $handler        The handler to register.
     * @param WebhookAuthentication|null $authentication The authentication mechanism used for this specific handler.
     */
    public function registerHandler(string $eventName, WebhookHandlerInterface $handler, WebhookAuthentication $authentication = null) : void
    {
        if (!isset($this->handlers[$eventName])) {
            $this->handlers[$eventName] = [];
        }

        $this->handlers[$eventName][] = [
            'handler'        => $handler,
            'authentication' => $authentication,
        ];
    }

    /**
     * Triggers a specific event and executes all registered handlers for that event.
     *
     * @param WebhookEvent $event The event to trigger.
     *
     * @throws Exception If the client is an instance of AsyncWebhookClient and the promise is not fulfilled.
     */
    public function triggerEvent(WebhookEvent $event) : void
    {
        $this->logger->log(sprintf('Triggering event "%s"', $event->getName()));

        foreach ($this->handlers[$event->getName()] as $handlerData) {
            $handler = $handlerData['handler'];
            $handler->handle($event);
        }

        if ($this->client instanceof AsyncWebhookClient) {
            $this->client->send($event->getWebhook())->wait();
        } else {
            $this->client->send($event->getWebhook());
        }

        $this->logger->log(sprintf('Event "%s" completed with response code %d', $event->getName(), $event->getWebhook()->getResponseCode()));
    }
}
