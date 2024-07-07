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
     * @var WebhookAuthenticationInterface The authentication mechanism used for webhook requests.
     */
    private WebhookAuthenticationInterface $authentication;

    /**
     * @var WebhookLoggerInterface The logger used to log webhook events.
     */
    private WebhookLoggerInterface $logger;

    /**
     * WebhookManager constructor.
     *
     * @param WebhookClientInterface         $client         The webhook client used to send requests.
     * @param WebhookAuthenticationInterface $authentication The authentication mechanism used for webhook requests.
     * @param WebhookLoggerInterface|null    $logger         The logger used to log webhook events.
     */
    public function __construct(WebhookClientInterface $client, WebhookAuthenticationInterface $authentication, WebhookLoggerInterface $logger = null)
    {
        $this->client         = $client;
        $this->authentication = $authentication;
        $this->logger         = $logger;
    }

    /**
     * Registers a handler for a specific event name.
     *
     * @param string                              $eventName      The name of the event to register the handler for.
     * @param WebhookHandlerInterface             $handler        The handler to register.
     * @param WebhookAuthenticationInterface|null $authentication The authentication mechanism used for this specific handler.
     */
    public function registerHandler(string $eventName, WebhookHandlerInterface $handler, WebhookAuthenticationInterface $authentication = null) : void
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

        if (isset($this->handlers[$event->getName()])) {
            foreach ($this->handlers[$event->getName()] as $handlerData) {
                $handlerData['handler']->handle($event);
            }
        }

        if ($this->client instanceof AsyncWebhookClient) {
            $this->client->send($event->getWebhook())->wait();
        } else {
            $this->client->send($event->getWebhook());
        }

        $this->logger->log(sprintf('Event "%s" completed with response code %d', $event->getName(), $event->getWebhook()->getResponseCode()));
    }

    /**
     * Checks if a specific handler is registered for a specific event.
     *
     * @param string                  $eventName The name of the event to check.
     * @param WebhookHandlerInterface $handler   The handler to check.
     *
     * @return bool True if the handler is registered, false otherwise.
     */
    public function hasHandler(string $eventName, WebhookHandlerInterface $handler) : bool
    {
        if (!isset($this->handlers[$eventName])) {
            return false;
        }

        foreach ($this->handlers[$eventName] as $handlerData) {
            if ($handlerData['handler'] === $handler) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns all registered handlers for a specific event.
     *
     * @return array
     */
    public function getHandlers() : array
    {
        return $this->handlers;
    }
}
